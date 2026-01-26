<x-filament-panels::page>
    <div class="space-y-6">
        <!-- QR Scanner Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Scan QR Code Member</h3>

            <!-- QR Code Scanner using device camera -->
            <div class="mb-4">
                <div id="qr-reader" style="width: 100%; max-width: 500px; margin: 0 auto;"></div>
            </div>
            @if(!$scannedUser)
            <div class="flex justify-center mt-4">
                <button onclick="window.location.reload()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow border-2 border-blue-700">
                    Refresh Kamera
                </button>
            </div>
            @endif
        </div>

        <!-- Scanned User Info -->
        @if($scannedUser)
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-4">
                <i class="fas fa-check-circle mr-2"></i>Member Terdeteksi
            </h3>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Nama:</p>
                    <p class="font-semibold">{{ $scannedUser->nama_user }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Email:</p>
                    <p class="font-semibold">{{ $scannedUser->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Poin Saat Ini:</p>
                    <p class="font-semibold text-lg text-green-600">{{ number_format($scannedUser->points, 0, ',', '.') }} Poin</p>
                </div>
            </div>
            <!-- Add Points Form -->
            <div class="mt-4 pt-4 border-t border-green-200 dark:border-green-800">
                <label class="block text-sm font-medium mb-2">Total Belanja (Rp):</label>
                <input
                    type="number"
                    wire:model="amount"
                    class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600 mb-10"
                    placeholder="50000">
                <div class="flex justify-center mt-6">
                    <button
                        wire:click="addPoints"
                        class="max-w-xs w-full bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded font-semibold border-2 border-green-700">
                        Tambah Poin
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Include QR Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let html5QrCode = null;
        function startQRScanner() {
            if (html5QrCode) {
                try { html5QrCode.stop(); } catch(e) {}
            }
            html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                (decodedText, decodedResult) => {
                    @this.set('qrData', decodedText);
                    @this.call('processQR');
                    html5QrCode.stop();
                },
                (errorMessage) => {}
            ).catch((err) => {
                console.error('Unable to start scanning', err);
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            startQRScanner();
        });
        if (window.Livewire) {
            window.Livewire.hook('message.processed', (message, component) => {
                // Jika scannedUser sudah null, restart scanner
                if (!component.get('scannedUser')) {
                    setTimeout(() => {
                        startQRScanner();
                    }, 300);
                }
            });
        }
    </script>
</x-filament-panels::page>