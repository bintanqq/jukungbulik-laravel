<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Scanner Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
            <h2 class="text-xl font-bold mb-4">Scan QR atau Input Kode Tiket</h2>
            
            <div x-data="{
                initScanner() {
                    if (typeof Html5QrcodeScanner === 'undefined') {
                        let script = document.createElement('script');
                        script.src = 'https://unpkg.com/html5-qrcode';
                        script.onload = () => this.startScanner();
                        document.head.appendChild(script);
                    } else {
                        this.startScanner();
                    }
                },
                startScanner() {
                    let html5QrcodeScanner = new Html5QrcodeScanner('qr-reader', { fps: 10, qrbox: {width: 250, height: 250} });
                    html5QrcodeScanner.render((decodedText) => {
                        $wire.set('ticketCode', decodedText);
                        $wire.verifyTicket();
                    });
                }
            }" x-init="initScanner()" class="mb-6">
                <div id="qr-reader" class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700" wire:ignore></div>
            </div>

            <form wire:submit.prevent="verifyTicket" class="space-y-4">
                <input type="text" wire:model="ticketCode" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-lg uppercase tracking-wider p-4" placeholder="Contoh: JB2026-A3F7B2C9" autofocus>
                <x-filament::button type="submit" size="lg" class="w-full">
                    Cek Tiket
                </x-filament::button>
            </form>

            @if($result)
                <div class="mt-6 p-4 rounded-lg border {{ 
                    $result['status'] == 'valid' ? 'bg-green-50 border-green-200 text-green-700 dark:bg-green-900/30 dark:border-green-800 dark:text-green-400' : 
                    ($result['status'] == 'already_scanned' ? 'bg-yellow-50 border-yellow-200 text-yellow-700 dark:bg-yellow-900/30 dark:border-yellow-800 dark:text-yellow-400' : 'bg-red-50 border-red-200 text-red-700 dark:bg-red-900/30 dark:border-red-800 dark:text-red-400') 
                }}">
                    <h3 class="font-bold text-lg mb-2">{{ $result['message'] }}</h3>
                    
                    @if(isset($result['order']))
                        <div class="mt-4 space-y-2 text-sm text-gray-700 dark:text-gray-300">
                            <div><span class="font-semibold">Nama:</span> {{ $result['order']->nama }}</div>
                            <div><span class="font-semibold">Kategori:</span> {{ $result['order']->ticketCategory->name }}</div>
                            <div><span class="font-semibold">Jumlah Tiket:</span> {{ $result['order']->quantity }} orang</div>
                            <div><span class="font-semibold">WhatsApp:</span> {{ $result['order']->whatsapp }}</div>
                        </div>

                        @if($result['status'] == 'valid')
                            <div class="mt-6">
                                <x-filament::button wire:click="markAsScanned" color="success" size="lg" class="w-full">
                                    Tandai Masuk (Scan)
                                </x-filament::button>
                            </div>
                        @endif
                    @endif
                </div>
            @endif
        </div>

        <!-- History -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
            <h2 class="text-xl font-bold mb-4">Riwayat Sesi Ini</h2>
            @php $history = session('scan_history', []); @endphp
            
            @if(count($history) > 0)
                <ul class="space-y-3">
                    @foreach($history as $item)
                        <li class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <div>
                                <div class="font-bold text-gray-900 dark:text-gray-100">{{ $item['code'] }}</div>
                                <div class="text-xs text-gray-500">{{ $item['time'] }}</div>
                            </div>
                            <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-900/30 dark:text-green-400">
                                {{ $item['status'] }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-gray-500 text-center py-8">Belum ada tiket yang di-scan di sesi ini.</div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
