<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminPortfolioController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $password = env('ADMIN_PASSWORD', 'admin123');
        
        if ($request->password === $password) {
            Session::put('admin_authenticated', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'パスワードが正しくありません']);
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Session::forget('admin_authenticated');
        return redirect()->route('admin.login');
    }

    /**
     * Show dashboard
     */
    public function dashboard()
    {
        try {
            $portfolios = Portfolio::orderBy('display_order')->orderBy('created_at', 'desc')->get();
            $heroStats = \App\Models\HeroStat::orderBy('display_order')->get();
            $services = \App\Models\Service::orderBy('display_order')->get();
        } catch (\Exception $e) {
            // Database connection error - use empty collections
            $portfolios = collect();
            $heroStats = collect();
            $services = collect();
        }
        return view('admin.dashboard', compact('portfolios', 'heroStats', 'services'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $portfolios = Portfolio::orderBy('display_order')->orderBy('created_at', 'desc')->get();
        } catch (\Exception $e) {
            // Database connection error - use empty collection
            $portfolios = collect();
        }
        return view('admin.portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.portfolios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'url' => 'nullable|url',
            'display_order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            try {
                $disk = config('filesystems.default', 'public');
                Log::info('Uploading image to disk: ' . $disk);
                Log::info('R2 Config Check:', [
                    'endpoint' => config('filesystems.disks.r2.endpoint'),
                    'bucket' => config('filesystems.disks.r2.bucket'),
                    'key' => config('filesystems.disks.r2.key') ? 'set' : 'not set',
                    'secret' => config('filesystems.disks.r2.secret') ? 'set' : 'not set',
                    'use_path_style' => config('filesystems.disks.r2.use_path_style_endpoint'),
                ]);
                
                $imagePath = $request->file('image')->store('portfolios', $disk);
                Log::info('Image uploaded successfully: ' . $imagePath);
                $validated['image_path'] = $imagePath;
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                    'disk' => $disk ?? 'unknown',
                ]);
                return back()->withErrors(['image' => '画像のアップロードに失敗しました: ' . $e->getMessage()])->withInput();
            }
        }

        $validated['is_published'] = $request->has('is_published');

        Portfolio::create($validated);

        return redirect()->route('admin.portfolios.index')->with('success', '制作実績を追加しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolios.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        return view('admin.portfolios.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $portfolio = Portfolio::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'url' => 'nullable|url',
            'display_order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            try {
                // Delete old image
                $disk = config('filesystems.default', 'public');
                if ($portfolio->image_path) {
                    Storage::disk($disk)->delete($portfolio->image_path);
                }
                Log::info('Uploading image to disk: ' . $disk);
                $imagePath = $request->file('image')->store('portfolios', $disk);
                Log::info('Image uploaded successfully: ' . $imagePath);
                $validated['image_path'] = $imagePath;
            } catch (\Exception $e) {
                Log::error('Image upload failed: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                    'disk' => $disk ?? 'unknown',
                ]);
                return back()->withErrors(['image' => '画像のアップロードに失敗しました: ' . $e->getMessage()])->withInput();
            }
        }

        $validated['is_published'] = $request->has('is_published');

        $portfolio->update($validated);

        return redirect()->route('admin.portfolios.index')->with('success', '制作実績を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $portfolio = Portfolio::findOrFail($id);
        
        // Delete image
        $disk = config('filesystems.default', 'public');
        if ($portfolio->image_path) {
            Storage::disk($disk)->delete($portfolio->image_path);
        }

        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('success', '制作実績を削除しました');
    }
}
