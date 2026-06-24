<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ToLetAdvertisement;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $featuredProperties = ToLetAdvertisement::approved()
            ->latest()
            ->take(4)
            ->get();

        $divisionCounts = ToLetAdvertisement::approved()
            ->selectRaw('division, COUNT(*) as total')
            ->groupBy('division')
            ->pluck('total', 'division');

        return view('frontend.home', compact('featuredProperties', 'divisionCounts'));
    }
}
