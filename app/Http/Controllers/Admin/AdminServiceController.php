<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('display_order')->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_svg' => 'required|string',
            'features' => 'required|string',
            'display_order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        // featuresを配列に変換
        $featuresArray = array_filter(array_map('trim', explode("\n", $validated['features'])));
        $validated['features'] = $featuresArray;
        $validated['is_published'] = $request->has('is_published');

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'サービスを追加しました');
    }

    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        // featuresを改行区切りの文字列に変換（ビュー用）
        $service->features_display = is_array($service->features) ? implode("\n", $service->features) : ($service->features ?? '');
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, string $id)
    {
        $service = Service::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_svg' => 'required|string',
            'features' => 'required|string',
            'display_order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        // featuresを配列に変換
        $featuresArray = array_filter(array_map('trim', explode("\n", $validated['features'])));
        $validated['features'] = $featuresArray;
        $validated['is_published'] = $request->has('is_published');

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'サービスを更新しました');
    }

    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'サービスを削除しました');
    }
}
