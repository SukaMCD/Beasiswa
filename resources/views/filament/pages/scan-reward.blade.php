<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Scan QR Claim Reward</h3>

            <div class="mb-4">
                <div id="qr-reader-reward" style="width: 100%; max-width: 500px; margin: 0 auto;"></div>
            </div>
            @if(!$scannedUser)
            <div class="flex justify-center mt-4">
                <button onclick="window.location.reload()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow border-2 border-blue-700">
                    Refresh Kamera
                </button>
            </div>
            @endif
        </div>

        @if($scannedUser)
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-green-800 dark:text-green-200 mb-4">
                Member Terdeteksi Untuk Reward
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

            @php
                $products = \App\Models\Product::orderBy('nama_produk')->get();
            @endphp

            <div class="mt-4 pt-4 border-t border-green-200 dark:border-green-800">
                <label class="block text-sm font-medium mb-2">Pilih Produk Reward:</label>
                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div class="col-span-2">
                        <select
                            wire:model="selectedProductId"
                            class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600">
                            <option value="">Pilih produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id_produk }}">{{ $product->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <input
                            type="number"
                            min="1"
                            wire:model="quantity"
                            class="w-full border rounded p-2 dark:bg-gray-700 dark:border-gray-600"
                            placeholder="Qty">
                    </div>
                </div>
                <div class="flex justify-center">
                    <button
                        type="button"
                        wire:click="addRewardItem"
                        class="max-w-xs w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-3 rounded font-semibold border-2 border-blue-700">
                        Tambah ke Reward
                    </button>
                </div>
            </div>

            @if(count($rewardItems))
            <div class="mt-6">
                <h4 class="text-md font-semibold mb-2">Daftar Produk Reward</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-green-200 dark:border-green-800">
                                <th class="py-2 text-left">Produk</th>
                                <th class="py-2 text-center">Qty</th>
                                <th class="py-2 text-right">Poin per item</th>
                                <th class="py-2 text-right">Subtotal Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rewardItems as $item)
                            <tr class="border-b border-green-100 dark:border-green-800">
                                <td class="py-2">{{ $item['nama_produk'] }}</td>
                                <td class="py-2 text-center">{{ $item['jumlah'] }}</td>
                                <td class="py-2 text-right">{{ number_format($item['points_per_item'], 0, ',', '.') }} Poin</td>
                                <td class="py-2 text-right">{{ number_format($item['points_subtotal'], 0, ',', '.') }} Poin</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-between items-center">
                    <p class="text-sm text-gray-700 dark:text-gray-300">Total Poin Digunakan:</p>
                    <p class="font-semibold text-lg text-red-600">
                        {{ number_format($this->totalRewardPoints, 0, ',', '.') }} Poin
                    </p>
                </div>

                <div class="flex justify-center mt-6">
                    <button
                        type="button"
                        wire:click="redeemReward"
                        class="max-w-xs w-full bg-green-500 hover:bg-green-600 text-white px-4 py-3 rounded font-semibold border-2 border-green-700">
                        Konfirmasi Klaim Reward
                    </button>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let html5QrCodeReward = null;
        function startRewardQRScanner() {
            if (html5QrCodeReward) {
                try { html5QrCodeReward.stop(); } catch(e) {}
            }
            html5QrCodeReward = new Html5Qrcode("qr-reader-reward");
            html5QrCodeReward.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                (decodedText, decodedResult) => {
                    @this.set('qrData', decodedText);
                    @this.call('processQR');
                    html5QrCodeReward.stop();
                },
                (errorMessage) => {}
            ).catch((err) => {
                console.error('Unable to start scanning', err);
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            startRewardQRScanner();
        });
        if (window.Livewire) {
            window.Livewire.hook('message.processed', (message, component) => {
                if (!component.get('scannedUser')) {
                    setTimeout(() => {
                        startRewardQRScanner();
                    }, 300);
                }
            });
        }
    </script>
</x-filament-panels::page>
