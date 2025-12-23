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
        $portfolios = Portfolio::where('is_published', true)
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->get();

        $heroStats = HeroStat::orderBy('display_order')->get();
        $services = Service::where('is_published', true)
            ->orderBy('display_order')
            ->get();

        return view('home', compact('portfolios', 'heroStats', 'services'));
    }
}
