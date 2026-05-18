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
