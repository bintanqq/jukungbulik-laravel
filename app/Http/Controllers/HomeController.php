<?php

namespace App\Http\Controllers;

use App\Models\PresalePeriod;
use App\Models\TicketCategory;

class HomeController extends Controller
{
    public function index()
    {
        $categories = TicketCategory::where('is_active', true)->get();
        $period = PresalePeriod::where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->where('is_active', true)
            ->first();
            
        return view('pages.home', compact('categories', 'period'));
    }
}
