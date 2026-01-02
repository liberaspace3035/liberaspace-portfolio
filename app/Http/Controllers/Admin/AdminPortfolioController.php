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
        dd($request->all(), $request->file('image'));
        try {
            dump('store');
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'required|image|max:10000',
                'url' => 'nullable|url',
                'display_order' => 'nullable|integer',
                'is_published' => 'boolean',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dump($e->errors());
            Log::error('Validation failed', [
                'errors' => $e->errors(),
            ]);
            return back()->withErrors($e->errors())->withInput();
        }

        // 最初にファイルの状態を確認
        Log::info('Store request received', [
            'has_file' => $request->hasFile('image'),
            'file_input_exists' => $request->has('image'),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
        ]);

        // PHP設定を詳細にログ出力
        Log::info('PHP Configuration:', [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'memory_limit' => ini_get('memory_limit'),
            'max_file_uploads' => ini_get('max_file_uploads'),
            'file_uploads' => ini_get('file_uploads') ? 'enabled' : 'disabled',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            Log::info('File details:', [
                'file_size' => $file->getSize(),
                'file_size_mb' => round($file->getSize() / 1024 / 1024, 2),
                'file_mime_type' => $file->getMimeType(),
                'file_original_name' => $file->getClientOriginalName(),
                'file_is_valid' => $file->isValid(),
                'file_error' => $file->getError(),
            ]);

            try {
                // R2またはS3を使用する場合は直接指定
                $filesystemDisk = env('FILESYSTEM_DISK', 'public');
                $disk = in_array($filesystemDisk, ['r2', 's3']) ? $filesystemDisk : 'public';
                
                Log::info('Uploading image', [
                    'disk' => $disk,
                    'env_FILESYSTEM_DISK' => $filesystemDisk,
                    'config_filesystems.default' => config('filesystems.default'),
                ]);

                // 使用するディスクの設定を確認
                $diskConfig = config("filesystems.disks.{$disk}");
                Log::info("Disk '{$disk}' Config Check:", [
                    'driver' => $diskConfig['driver'] ?? 'not set',
                    'endpoint' => $diskConfig['endpoint'] ?? 'not set',
                    'bucket' => $diskConfig['bucket'] ?? 'not set',
                    'key' => isset($diskConfig['key']) && $diskConfig['key'] ? 'set' : 'not set',
                    'secret' => isset($diskConfig['secret']) && $diskConfig['secret'] ? 'set' : 'not set',
                    'use_path_style_endpoint' => $diskConfig['use_path_style_endpoint'] ?? 'not set',
                ]);
                
                $imagePath = $request->file('image')->store('portfolios', $disk);
                Log::info('Image uploaded successfully: ' . $imagePath);
                $validated['image_path'] = $imagePath;
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
                $errorClass = get_class($e);
                
                Log::error('Image upload failed', [
                    'message' => $errorMessage,
                    'class' => $errorClass,
                    'trace' => $e->getTraceAsString(),
                    'disk' => $disk ?? 'unknown',
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
                
                // より詳細なエラーメッセージを表示
                $userMessage = '画像のアップロードに失敗しました。';
                if (str_contains($errorMessage, 'Could not resolve host')) {
                    $userMessage .= ' R2エンドポイントに接続できません。エンドポイントURLを確認してください。';
                } elseif (str_contains($errorMessage, 'Access Denied') || str_contains($errorMessage, '403')) {
                    $userMessage .= ' 認証情報が正しくないか、アクセス権限がありません。';
                } elseif (str_contains($errorMessage, 'No such bucket')) {
                    $userMessage .= ' バケットが見つかりません。バケット名を確認してください。';
                } else {
                    $userMessage .= ' エラー: ' . $errorMessage;
                }
                
                return back()->withErrors(['image' => $userMessage])->withInput();
            }
        } else {
            // ファイルがアップロードされていない場合
            Log::error('No file uploaded', [
                'has_file' => $request->hasFile('image'),
                'file_input_exists' => $request->has('image'),
                'all_input' => $request->all(),
            ]);
            
            // PHP設定の問題の可能性をチェック
            $uploadMaxFilesize = ini_get('upload_max_filesize');
            $postMaxSize = ini_get('post_max_size');
            $fileSize = $request->hasFile('image') ? $request->file('image')->getSize() : null;
            
            $errorMessage = '画像ファイルがアップロードされませんでした。';
            if ($fileSize && $uploadMaxFilesize) {
                $uploadMaxBytes = $this->convertToBytes($uploadMaxFilesize);
                if ($fileSize > $uploadMaxBytes) {
                    $errorMessage .= " ファイルサイズ（" . round($fileSize / 1024 / 1024, 2) . "MB）がPHPの設定（upload_max_filesize: {$uploadMaxFilesize}）を超えています。";
                }
            }
            if ($postMaxSize) {
                $postMaxBytes = $this->convertToBytes($postMaxSize);
                $contentLength = $request->header('Content-Length');
                if ($contentLength && $contentLength > $postMaxBytes) {
                    $errorMessage .= " POSTデータサイズがPHPの設定（post_max_size: {$postMaxSize}）を超えています。";
                }
            }
            
            return back()->withErrors(['image' => $errorMessage])->withInput();
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
            'image' => 'nullable|image|max:10000',
            'url' => 'nullable|url',
            'display_order' => 'nullable|integer',
            'is_published' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            Log::info('Update - File details:', [
                'file_size' => $file->getSize(),
                'file_size_mb' => round($file->getSize() / 1024 / 1024, 2),
                'file_mime_type' => $file->getMimeType(),
                'file_original_name' => $file->getClientOriginalName(),
                'file_is_valid' => $file->isValid(),
                'file_error' => $file->getError(),
            ]);

            try {
                // R2またはS3を使用する場合は直接指定
                $filesystemDisk = env('FILESYSTEM_DISK', 'public');
                $disk = in_array($filesystemDisk, ['r2', 's3']) ? $filesystemDisk : 'public';
                
                Log::info('Update - Uploading image', [
                    'disk' => $disk,
                    'env_FILESYSTEM_DISK' => $filesystemDisk,
                    'config_filesystems.default' => config('filesystems.default'),
                ]);

                // 使用するディスクの設定を確認
                $diskConfig = config("filesystems.disks.{$disk}");
                Log::info("Update - Disk '{$disk}' Config Check:", [
                    'driver' => $diskConfig['driver'] ?? 'not set',
                    'endpoint' => $diskConfig['endpoint'] ?? 'not set',
                    'bucket' => $diskConfig['bucket'] ?? 'not set',
                    'key' => isset($diskConfig['key']) && $diskConfig['key'] ? 'set' : 'not set',
                    'secret' => isset($diskConfig['secret']) && $diskConfig['secret'] ? 'set' : 'not set',
                    'use_path_style_endpoint' => $diskConfig['use_path_style_endpoint'] ?? 'not set',
                ]);
                
                // Delete old image
                if ($portfolio->image_path) {
                    Storage::disk($disk)->delete($portfolio->image_path);
                }
                
                $imagePath = $request->file('image')->store('portfolios', $disk);
                Log::info('Image uploaded successfully: ' . $imagePath);
                $validated['image_path'] = $imagePath;
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
                $errorClass = get_class($e);
                
                Log::error('Image upload failed', [
                    'message' => $errorMessage,
                    'class' => $errorClass,
                    'trace' => $e->getTraceAsString(),
                    'disk' => $disk ?? 'unknown',
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
                
                // より詳細なエラーメッセージを表示
                $userMessage = '画像のアップロードに失敗しました。';
                if (str_contains($errorMessage, 'Could not resolve host')) {
                    $userMessage .= ' R2エンドポイントに接続できません。エンドポイントURLを確認してください。';
                } elseif (str_contains($errorMessage, 'Access Denied') || str_contains($errorMessage, '403')) {
                    $userMessage .= ' 認証情報が正しくないか、アクセス権限がありません。';
                } elseif (str_contains($errorMessage, 'No such bucket')) {
                    $userMessage .= ' バケットが見つかりません。バケット名を確認してください。';
                } else {
                    $userMessage .= ' エラー: ' . $errorMessage;
                }
                
                return back()->withErrors(['image' => $userMessage])->withInput();
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
        
        // Delete image - R2またはS3を使用する場合は直接指定
        $filesystemDisk = env('FILESYSTEM_DISK', 'public');
        $disk = in_array($filesystemDisk, ['r2', 's3']) ? $filesystemDisk : 'public';
        
        Log::info('Delete - Using disk: ' . $disk);
        
        if ($portfolio->image_path) {
            Storage::disk($disk)->delete($portfolio->image_path);
        }

        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('success', '制作実績を削除しました');
    }

    /**
     * Convert PHP ini size string to bytes
     */
    private function convertToBytes(string $size): int
    {
        $size = trim($size);
        $last = strtolower($size[strlen($size) - 1]);
        $size = (int) $size;
        
        switch ($last) {
            case 'g':
                $size *= 1024;
                // fall through
            case 'm':
                $size *= 1024;
                // fall through
            case 'k':
                $size *= 1024;
        }
        
        return $size;
    }
}
