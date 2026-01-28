<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\User;
use Filament\Notifications\Notification;

class ScanQR extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static string $view = 'filament.pages.scan-qr';

    protected static ?string $slug = 'scan-qr';

    protected static ?string $navigationLabel = 'Scan QR';

    protected static ?string $title = 'Scan QR Member';

    protected static ?string $navigationGroup = 'Shop';

    // Livewire properties
    public $qrData = '';
    public $scannedUser = null;
    public $amount = '';

    /**
     * Process the scanned QR code data
     */
    public function processQR()
    {
        // Reset scanned user
        $this->scannedUser = null;

        if (empty($this->qrData)) {
            Notification::make()
                ->title('Data QR kosong!')
                ->danger()
                ->send();
            return;
        }

        try {
            // Parse QR data (expected format: {"id": 1, "exp": 1234567890})
            $data = json_decode($this->qrData, true);

            if (!$data || !isset($data['id'])) {
                throw new \Exception('Format QR tidak valid');
            }

            // Check expiration (4 minutes = 240000 milliseconds)
            if (isset($data['exp'])) {
                $currentTime = now()->timestamp * 1000; // Convert to milliseconds
                if ($currentTime > $data['exp']) {
                    Notification::make()
                        ->title('QR Code sudah kadaluarsa!')
                        ->warning()
                        ->send();
                    return;
                }
            }

            // Find user by ID
            $user = User::find($data['id']);

            if (!$user) {
                Notification::make()
                    ->title('User tidak ditemukan!')
                    ->danger()
                    ->send();
                return;
            }

            // Set scanned user
            $this->scannedUser = $user;

            Notification::make()
                ->title('Member berhasil terdeteksi!')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    /**
     * Add points to the scanned user
     */
    public function addPoints()
    {
        if (!$this->scannedUser) {
            Notification::make()
                ->title('Tidak ada member yang di-scan!')
                ->warning()
                ->send();
            return;
        }

        if (empty($this->amount) || $this->amount <= 0) {
            Notification::make()
                ->title('Masukkan total belanja yang valid!')
                ->warning()
                ->send();
            return;
        }

        try {
            $pointsToAdd = intdiv((int) $this->amount, 100);

            // Refresh user data from database
            $user = User::find($this->scannedUser->id_user);
            $newPoints = ($user->points ?? 0) + $pointsToAdd;
            $user->points = $newPoints;
            $user->save();

            Notification::make()
                ->title('Berhasil menambahkan ' . number_format($pointsToAdd, 0, ',', '.') . ' poin!')
                ->success()
                ->send();

            // Reset form
            $this->amount = '';
            $this->qrData = '';
            $this->scannedUser = null;
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }
}
