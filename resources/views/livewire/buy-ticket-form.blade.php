<div class="max-w-6xl mx-auto space-y-12">
    @if($errors->any())
        <div class="bg-destructive/10 border border-destructive text-destructive p-4 rounded-xl mb-6 text-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/beli-tiket') }}" method="POST" id="ticket-form" x-data="{ submitting: false }" @submit="submitting = true">
        @csrf
        
        <div class="text-center mb-8">
 
             @if($period && $period->discount > 0)
                 <div class="mt-4 inline-flex items-center gap-2 rounded-full bg-primary/10 border border-primary/30 px-4 py-2">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg>
                     <span class="text-sm font-medium text-primary">{{ $period->name }} - {{ $period->badge }}</span>
                 </div>
             @endif
         </div>
 
         <div class="grid gap-6 md:grid-cols-2 max-w-4xl mx-auto mb-12">
             @foreach($categories as $category)
                 @php
                     $remaining = $category->quota - $category->sold;
                     $isSoldOut = $remaining === 0;
                     $isSelected = $selectedCategory == $category->id;
                     $quotaPercentage = ($remaining / $category->quota) * 100;
                     $isLowStock = $quotaPercentage <= 20 && !$isSoldOut;
                 @endphp
                 <label for="category_{{ $category->id }}" class="relative rounded-xl border p-6 transition-all duration-300 cursor-pointer flex flex-col h-full {{ $isSelected ? 'border-primary bg-card/80 shadow-[0_0_30px_rgba(201,168,76,0.3)]' : 'border-border/50 bg-card/50 hover:border-primary/50 hover:bg-card/70' }} {{ ($isSoldOut || !$period) ? 'opacity-60 pointer-events-none cursor-not-allowed' : '' }} {{ $category->icon == 'crown' ? 'ring-1 ring-primary/20' : '' }}">
                     <input type="radio" id="category_{{ $category->id }}" wire:model.live="selectedCategory" name="category_id" value="{{ $category->id }}" class="sr-only" {{ ($isSoldOut || !$period) ? 'disabled' : '' }}>
                     
                     @if($category->icon == 'crown' && !$isSoldOut)
                         <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-primary text-primary-foreground px-3 py-1 rounded-full text-xs font-semibold flex items-center pointer-events-none">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 mr-1"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"/></svg>
                             PREMIUM
                         </div>
                     @endif
 
                     @if($isSoldOut)
                         <div class="absolute inset-0 flex items-center justify-center rounded-xl bg-background/80 backdrop-blur-sm z-10 pointer-events-none">
                             <span class="font-serif text-xl font-bold text-destructive">HABIS TERJUAL</span>
                         </div>
                     @endif
 
                     @if($isSelected)
                         <div class="absolute top-3 right-3 h-6 w-6 rounded-full bg-primary flex items-center justify-center">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary-foreground"><path d="M20 6 9 17l-5-5"/></svg>
                         </div>
                         <div class="absolute inset-0 rounded-xl border-2 border-primary gold-glow pointer-events-none"></div>
                     @endif
 
                     <div class="flex items-center gap-3 mb-4">
                         <div class="h-12 w-12 rounded-full flex items-center justify-center {{ $category->icon == 'crown' ? 'bg-primary/20 text-primary' : 'bg-secondary text-foreground/70' }}">
                             @if($category->icon == 'crown')
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="m2 4 3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"/></svg>
                             @else
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/></svg>
                             @endif
                         </div>
                         <h3 class="font-serif text-2xl font-bold text-foreground">{{ $category->name }}</h3>
                     </div>
 
                     <div class="mb-6">
                         @php
                             $catPrice = $category->base_price * (1 - ($period ? $period->discount : 0) / 100);
                         @endphp
                         <span class="font-serif text-3xl font-bold text-primary">Rp{{ number_format($catPrice, 0, ',', '.') }}</span>
                         @if($period && $period->discount > 0)
                             <span class="ml-2 text-sm text-foreground/50 line-through">Rp{{ number_format($category->base_price, 0, ',', '.') }}</span>
                         @endif
                         <span class="block text-xs text-foreground/50 mt-1">per tiket</span>
                     </div>
 
                     <div class="space-y-2 mt-auto w-full">
                         <div class="flex justify-between text-xs">
                             <span class="{{ $isLowStock ? 'text-destructive' : 'text-foreground/60' }}">
                                 @if($isLowStock)
                                     <span class="font-medium mr-1">Hampir Habis!</span>
                                 @endif
                                 Sisa {{ $remaining }} tiket
                             </span>
                             <span class="text-foreground/40">dari {{ $category->quota }}</span>
                         </div>
                         <div class="h-2 w-full rounded-full bg-secondary overflow-hidden">
                             <div class="h-full rounded-full transition-colors {{ $isLowStock ? 'bg-destructive' : 'bg-primary' }}" style="width: {{ $quotaPercentage }}%"></div>
                         </div>
                     </div>
                 </label>
             @endforeach
         </div>
 
         <div class="grid gap-8 lg:grid-cols-5">
             <!-- Buyer Form -->
             <div class="lg:col-span-3">
                 <div class="rounded-xl border border-border/50 bg-card/50 p-6 {{ !$selectedCategory ? 'opacity-50 pointer-events-none' : '' }}">
                     <div class="flex items-center gap-3 mb-6">
                         <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-primary"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                         </div>
                         <div>
                             <h3 class="font-serif text-xl font-bold text-foreground">Data Pemesan</h3>
                             <p class="text-sm text-foreground/60">Isi data diri Anda dengan benar</p>
                         </div>
                     </div>
 
                     <div class="space-y-5">
                         <div class="space-y-2">
                             <label class="text-foreground/80 flex items-center gap-2 text-sm font-medium">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                 Nama Lengkap <span class="text-destructive">*</span>
                             </label>
                             <input type="text" name="nama" wire:model.live="nama" required placeholder="Sesuai kartu identitas (KTP/SIM)" class="flex h-10 w-full rounded-md border bg-secondary/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 border-border/50 focus:border-primary focus:ring-primary text-foreground" {{ !$period ? 'disabled' : '' }}>
                             @error('nama') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror
                         </div>
 
                         <div class="space-y-2">
                             <label class="text-foreground/80 flex items-center gap-2 text-sm font-medium">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                                 Nomor WhatsApp <span class="text-destructive">*</span>
                             </label>
                             <input type="tel" name="whatsapp" wire:model.live="whatsapp" required placeholder="Contoh: 081234567890" class="flex h-10 w-full rounded-md border bg-secondary/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 border-border/50 focus:border-primary focus:ring-primary text-foreground" {{ !$period ? 'disabled' : '' }}>
                             @error('whatsapp') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror
                             <p class="text-xs text-foreground/50">Pastikan nomor aktif. E-ticket akan dikirimkan ke nomor ini.</p>
                         </div>
 
                         <div class="space-y-2">
                             <label class="text-foreground/80 flex items-center gap-2 text-sm font-medium">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                 Alamat Email <span class="text-destructive">*</span>
                             </label>
                             <input type="email" name="email" wire:model.live="email" required placeholder="contoh@gmail.com" class="flex h-10 w-full rounded-md border bg-secondary/50 px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 border-border/50 focus:border-primary focus:ring-primary text-foreground" {{ !$period ? 'disabled' : '' }}>
                             @error('email') <span class="text-xs text-destructive mt-1 block">{{ $message }}</span> @enderror
                             <p class="text-xs text-foreground/50">Invoice dan bukti pembayaran akan dikirim ke email ini.</p>
                         </div>

                        <div class="space-y-2">
                            <label class="text-foreground/80 flex items-center gap-2 text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 text-primary"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/></svg>
                                Jumlah Tiket
                            </label>
                            <div class="flex items-center gap-4">
                                <button type="button" wire:click="decrementQuantity" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border bg-background hover:bg-accent hover:text-accent-foreground h-10 w-10 border-border/50 hover:border-primary hover:bg-primary/10" {{ (!$period || $quantity <= 1) ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M5 12h14"/></svg>
                                </button>
                                <input type="hidden" name="quantity" value="{{ $quantity }}">
                                <span class="font-serif text-2xl font-bold text-primary w-12 text-center">{{ $quantity }}</span>
                                <button type="button" wire:click="incrementQuantity" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border bg-background hover:bg-accent hover:text-accent-foreground h-10 w-10 border-border/50 hover:border-primary hover:bg-primary/10" {{ (!$period || $quantity >= 5) ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </button>
                            </div>
                            <p class="text-xs text-foreground/50">Maksimal 5 tiket per transaksi</p>
                        </div>

                        <div class="flex items-start gap-3 p-4 rounded-lg bg-primary/5 border border-primary/20">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-primary mt-0.5 flex-shrink-0"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                            <p class="text-sm text-foreground/70">E-ticket akan dikirimkan otomatis melalui pesan WhatsApp setelah pembayaran dikonfirmasi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="rounded-xl border border-border/50 bg-card/50 p-6 sticky top-24">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5 text-primary"><path d="M21 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v3"/><path d="M21 16v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3"/><path d="M4 12H2"/><path d="M10 12H8"/><path d="M16 12h-2"/><path d="M22 12h-2"/></svg>
                        </div>
                        <h3 class="font-serif text-xl font-bold text-foreground">Ringkasan Pesanan</h3>
                    </div>

                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-foreground/60">Kategori Tiket</span>
                            <span class="font-medium text-foreground text-right">{{ $categories->firstWhere('id', $selectedCategory)?->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-foreground/60">Harga Satuan</span>
                            <span class="font-medium text-foreground">Rp{{ number_format($currentPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-foreground/60">Jumlah</span>
                            <span class="font-medium text-foreground">{{ $quantity }} Tiket</span>
                        </div>
                        
                        <div class="my-4 border-t border-dashed border-border/50"></div>
                        
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-sm text-foreground/60 mb-1">Total Pembayaran</p>
                            </div>
                            <div class="text-right">
                                <span class="font-serif text-3xl font-bold text-primary">Rp{{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button type="submit" form="ticket-form" class="inline-flex items-center justify-center whitespace-nowrap text-sm ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none border border-transparent hover:bg-primary/90 w-full font-bold bg-primary text-primary-foreground py-6 rounded-xl text-lg hover:shadow-[0_0_20px_rgba(201,168,76,0.3)] hover:-translate-y-0.5 disabled:opacity-50 disabled:hover:translate-y-0" {{ (!$selectedCategory || $nama == '' || $whatsapp == '' || $email == '' || !$period) ? 'disabled' : '' }}>
                            Lanjutkan Pembayaran
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2 h-5 w-5"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </button>
                        <p class="text-xs text-center text-foreground/50 flex items-center justify-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-3 w-3 text-primary"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Mendukung QRIS, Transfer Bank, E-Wallet & Lainnya
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
