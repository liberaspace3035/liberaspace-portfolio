@extends('admin.layout')

@section('title', '制作実績追加')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">制作実績を追加</h1>
    <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">戻る</a>
</div>

<div class="card">
    @if ($errors->any())
    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="color: #ef4444; margin-bottom: 1rem; font-size: 1.125rem; font-weight: 600;">エラーが発生しました</h3>
        <ul style="list-style: none; padding: 0; margin: 0;">
            @foreach ($errors->all() as $error)
            <li style="color: #ef4444; margin-bottom: 0.5rem;">• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('admin.portfolios.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="title">タイトル *</label>
            <input type="text" id="title" name="title" class="form-input" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="category">カテゴリ *</label>
            <input type="text" id="category" name="category" class="form-input" value="{{ old('category') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">説明</label>
            <textarea id="description" name="description" class="form-textarea">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="image">画像 *</label>
            <input type="file" id="image" name="image" class="form-input" accept="image/*" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="url">URL</label>
            <input type="url" id="url" name="url" class="form-input" value="{{ old('url') }}" placeholder="https://example.com">
        </div>

        <div class="form-group">
            <label class="form-label" for="display_order">表示順</label>
            <input type="number" id="display_order" name="display_order" class="form-input" value="{{ old('display_order', 0) }}">
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : 'checked' }}>
                <label class="form-label" for="is_published" style="margin: 0;">公開する</label>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">保存</button>
            <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">キャンセル</a>
        </div>
    </form>
</div>
@endsection
