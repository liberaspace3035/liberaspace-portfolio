<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\HeroStat;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $portfolios = Portfolio::where('is_published', true)
                ->orderBy('display_order')
                ->orderBy('created_at', 'desc')
                ->get();

            $heroStats = HeroStat::orderBy('display_order')->get();
            $services = Service::where('is_published', true)
                ->orderBy('display_order')
                ->get();
        } catch (\Exception $e) {
            // Database connection error - use empty collections
            $portfolios = collect();
            $heroStats = collect();
            $services = collect();
        }

        return view('home', compact('portfolios', 'heroStats', 'services'));
    }
}
