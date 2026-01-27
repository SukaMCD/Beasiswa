<?php

namespace App\Filament\Pages;

use App\Models\Product;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ScanReward extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static string $view = 'filament.pages.scan-reward';

    protected static ?string $slug = 'scan-reward';

    protected static ?string $navigationLabel = 'Scan Reward';

    protected static ?string $title = 'Scan QR Reward';

    protected static ?string $navigationGroup = 'Membership';

    public $qrData = '';

    public $scannedUser = null;

    public $selectedProductId = '';

    public $quantity = 1;

    public $rewardItems = [];

    public function processQR()
    {
        $this->scannedUser = null;
        $this->rewardItems = [];

        if (empty($this->qrData)) {
            Notification::make()
                ->title('Data QR kosong!')
                ->danger()
                ->send();
            return;
        }

        try {
            $data = json_decode($this->qrData, true);

            if (!$data || !isset($data['id'])) {
                throw new \Exception('Format QR tidak valid');
            }

            if (isset($data['type']) && $data['type'] !== 'reward') {
                Notification::make()
                    ->title('QR ini bukan untuk klaim reward!')
                    ->warning()
                    ->send();
                return;
            }

            if (isset($data['exp'])) {
                $currentTime = now()->timestamp * 1000;
                if ($currentTime > $data['exp']) {
                    Notification::make()
                        ->title('QR Code sudah kadaluarsa!')
                        ->warning()
                        ->send();
                    return;
                }
            }

            $user = User::find($data['id']);

            if (!$user) {
                Notification::make()
                    ->title('User tidak ditemukan!')
                    ->danger()
                    ->send();
                return;
            }

            $this->scannedUser = $user;

            Notification::make()
                ->title('Member untuk klaim reward berhasil terdeteksi!')
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    public function addRewardItem()
    {
        if (!$this->scannedUser) {
            Notification::make()
                ->title('Tidak ada member yang di-scan!')
                ->warning()
                ->send();
            return;
        }

        if (empty($this->selectedProductId)) {
            Notification::make()
                ->title('Pilih produk reward terlebih dahulu!')
                ->warning()
                ->send();
            return;
        }

        if (empty($this->quantity) || $this->quantity <= 0) {
            Notification::make()
                ->title('Masukkan jumlah produk yang valid!')
                ->warning()
                ->send();
            return;
        }

        $product = Product::find($this->selectedProductId);

        if (!$product) {
            Notification::make()
                ->title('Produk tidak ditemukan!')
                ->danger()
                ->send();
            return;
        }

        $pointsPerItem = 1000;
        $pointsSubtotal = $pointsPerItem * (int) $this->quantity;

        $this->rewardItems[] = [
            'id_produk' => $product->id_produk,
            'nama_produk' => $product->nama_produk,
            'jumlah' => (int) $this->quantity,
            'points_per_item' => $pointsPerItem,
            'points_subtotal' => $pointsSubtotal,
        ];

        $this->selectedProductId = '';
        $this->quantity = 1;
    }

    public function redeemReward()
    {
        if (!$this->scannedUser) {
            Notification::make()
                ->title('Tidak ada member yang di-scan!')
                ->warning()
                ->send();
            return;
        }

        if (empty($this->rewardItems)) {
            Notification::make()
                ->title('Tambahkan produk reward terlebih dahulu!')
                ->warning()
                ->send();
            return;
        }

        $totalPoints = $this->getTotalRewardPointsProperty();

        $user = User::find($this->scannedUser->id_user);

        if (!$user) {
            Notification::make()
                ->title('User tidak ditemukan!')
                ->danger()
                ->send();
            return;
        }

        if (($user->points ?? 0) < $totalPoints) {
            Notification::make()
                ->title('Poin member tidak mencukupi untuk reward ini!')
                ->warning()
                ->send();
            return;
        }

        $user->points = ($user->points ?? 0) - $totalPoints;
        $user->save();

        Notification::make()
            ->title('Reward berhasil diklaim, ' . number_format($totalPoints, 0, ',', '.') . ' poin terpakai!')
            ->success()
            ->send();

        $this->qrData = '';
        $this->scannedUser = null;
        $this->selectedProductId = '';
        $this->quantity = 1;
        $this->rewardItems = [];
    }

    public function getTotalRewardPointsProperty()
    {
        return collect($this->rewardItems)->sum('points_subtotal');
    }
}
