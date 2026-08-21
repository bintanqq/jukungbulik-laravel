<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: Scanner & Input (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            <x-filament::section heading="Pemeriksaan Kode Tiket" description="Scan QR Code menggunakan kamera atau ketik kode tiket secara manual.">
                
                <!-- Live QR Scanner Container -->
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
                        let html5QrcodeScanner = new Html5QrcodeScanner('qr-reader', { fps: 10, qrbox: {width: 240, height: 240} });
                        html5QrcodeScanner.render((decodedText) => {
                            $wire.set('ticketCode', decodedText);
                            $wire.verifyTicket();
                        });
                    }
                }" x-init="initScanner()" class="mb-6">
                    <div id="qr-reader" class="overflow-hidden rounded-lg border border-gray-300 dark:border-gray-700" wire:ignore></div>
                </div>

                <!-- Input Form -->
                <form wire:submit.prevent="verifyTicket" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Masukkan Kode Tiket</label>
                        <input type="text" 
                               wire:model="ticketCode" 
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-lg font-mono uppercase tracking-wider p-4 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all" 
                               placeholder="JB2026-A3F7B2C9" 
                               autofocus>
                    </div>

                    <x-filament::button type="submit" size="lg" class="w-full">
                        Periksa Status Tiket
                    </x-filament::button>
                </form>

                <!-- Result Status Box -->
                @if($result)
                    <div class="mt-6 border-t border-gray-200 dark:border-gray-800 pt-6">
                        <div class="rounded-lg p-5 border {{ 
                            $result['status'] == 'valid' ? 'bg-emerald-50 border-emerald-300 text-emerald-900 dark:bg-emerald-950/40 dark:border-emerald-700 dark:text-emerald-300' : 
                            ($result['status'] == 'already_scanned' ? 'bg-amber-50 border-amber-300 text-amber-900 dark:bg-amber-950/40 dark:border-amber-700 dark:text-amber-300' : 'bg-rose-50 border-rose-300 text-rose-900 dark:bg-rose-950/40 dark:border-rose-700 dark:text-rose-300') 
                        }}">
                            <h3 class="font-bold text-lg tracking-wide mb-2">{{ $result['message'] }}</h3>

                            @if(isset($result['order']))
                                <div class="mt-4 pt-4 border-t border-current/20 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-xs uppercase tracking-wider opacity-75 block font-semibold mb-1">Nama Pemilik Tiket</span>
                                        <span class="font-bold text-base">{{ $result['order']->nama }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs uppercase tracking-wider opacity-75 block font-semibold mb-1">Kategori Tiket</span>
                                        <span class="font-bold text-base">{{ $result['order']->ticketCategory->name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs uppercase tracking-wider opacity-75 block font-semibold mb-1">Jumlah Orang</span>
                                        <span class="font-bold text-base">{{ $result['order']->quantity }} Orang</span>
                                    </div>
                                    <div>
                                        <span class="text-xs uppercase tracking-wider opacity-75 block font-semibold mb-1">Nomor WhatsApp</span>
                                        <span class="font-bold text-base font-mono">{{ $result['order']->whatsapp }}</span>
                                    </div>
                                </div>

                                @if($result['status'] == 'valid')
                                    <div class="mt-5">
                                        <x-filament::button wire:click="markAsScanned" color="success" size="lg" class="w-full">
                                            Konfirmasi Masuk Venue (Scan)
                                        </x-filament::button>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
            </x-filament::section>
        </div>

        <!-- Right Column: Scan History (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <x-filament::section heading="Riwayat Scan Sesi Ini" description="10 transaksi verifikasi tiket terakhir.">
                @php $history = session('scan_history', []); @endphp
                
                @if(count($history) > 0)
                    <div class="space-y-3">
                        @foreach($history as $item)
                            <div class="flex items-center justify-between p-3.5 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-lg">
                                <div>
                                    <div class="font-mono font-bold text-sm text-gray-900 dark:text-gray-100">{{ $item['code'] }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $item['time'] }} WITA</div>
                                </div>
                                <span class="inline-flex items-center rounded px-2.5 py-1 text-xs font-semibold bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-700">
                                    {{ $item['status'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 border border-dashed border-gray-300 dark:border-gray-700 rounded-lg text-sm text-gray-500 dark:text-gray-400">
                        Belum ada riwayat verifikasi pada sesi ini.
                    </div>
                @endif
            </x-filament::section>
        </div>

    </div>
</x-filament-panels::page>
