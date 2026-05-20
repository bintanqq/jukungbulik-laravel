<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TicketCategory;
use App\Models\PresalePeriod;

class BuyTicketForm extends Component
{
    public string $nama = '';
    public string $whatsapp = '';
    public string $email = '';
    public string $selectedCategory = '';
    public int $quantity = 1;
    public bool $isLoading = false;

    protected $rules = [
        'nama'     => 'required|string|min:3|max:100',
        'whatsapp' => 'required|regex:/^08[0-9]{8,12}$/',
        'email'    => 'required|email|max:150',
        'quantity' => 'required|integer|min:1|max:5',
    ];

    protected $messages = [
        'nama.required' => 'Nama lengkap wajib diisi.',
        'nama.min' => 'Nama minimal terdiri dari 3 karakter.',
        'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
        'whatsapp.regex' => 'Format nomor WhatsApp tidak valid (contoh: 081234567890).',
        'email.required' => 'Alamat email wajib diisi.',
        'email.email' => 'Format alamat email tidak valid.',
        'quantity.required' => 'Jumlah tiket wajib diisi.',
        'quantity.min' => 'Minimal pembelian 1 tiket.',
        'quantity.max' => 'Maksimal pembelian 5 tiket.',
    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function mount()
    {
        $categories = TicketCategory::where('is_active', true)->get();
        if ($categories->isNotEmpty()) {
            $this->selectedCategory = (string) $categories->first()->id;
        }
    }

    public function incrementQuantity()
    {
        if ($this->getPresaleInfo() && $this->quantity < 5) {
            $this->quantity++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->getPresaleInfo() && $this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function getCurrentPrice()
    {
        $category = TicketCategory::find($this->selectedCategory);
        if (!$category) return 0;
        
        $period = $this->getPresaleInfo();
        if (!$period) return $category->base_price;
        
        return $category->base_price * (1 - $period->discount / 100);
    }

    public function getTotalPrice()
    {
        return $this->getCurrentPrice() * $this->quantity;
    }

    public function getPresaleInfo()
    {
        return PresalePeriod::where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->where('is_active', true)
            ->first();
    }

    public function render()
    {
        return view('livewire.buy-ticket-form', [
            'categories' => TicketCategory::where('is_active', true)->get(),
            'period' => $this->getPresaleInfo(),
            'currentPrice' => $this->getCurrentPrice(),
            'totalPrice' => $this->getTotalPrice(),
        ]);
    }
}
