<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroStat;
use Illuminate\Http\Request;

class AdminHeroStatController extends Controller
{
    public function index()
    {
        try {
            $stats = HeroStat::orderBy('display_order')->get();
        } catch (\Exception $e) {
            // Database connection error - use empty collection
            $stats = collect();
        }
        return view('admin.hero-stats.index', compact('stats'));
    }

    public function create()
    {
        return view('admin.hero-stats.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|integer|min:0',
            'display_order' => 'nullable|integer',
        ]);

        HeroStat::create($validated);

        return redirect()->route('admin.hero-stats.index')->with('success', '実績を追加しました');
    }

    public function edit(string $id)
    {
        $stat = HeroStat::findOrFail($id);
        return view('admin.hero-stats.edit', compact('stat'));
    }

    public function update(Request $request, string $id)
    {
        $stat = HeroStat::findOrFail($id);

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|integer|min:0',
            'display_order' => 'nullable|integer',
        ]);

        $stat->update($validated);

        return redirect()->route('admin.hero-stats.index')->with('success', '実績を更新しました');
    }

    public function destroy(string $id)
    {
        $stat = HeroStat::findOrFail($id);
        $stat->delete();

        return redirect()->route('admin.hero-stats.index')->with('success', '実績を削除しました');
    }
}
