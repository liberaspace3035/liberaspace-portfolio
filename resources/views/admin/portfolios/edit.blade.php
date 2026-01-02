@extends('admin.layout')

@section('title', '制作実績編集')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">制作実績を編集</h1>
    <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">戻る</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.portfolios.update', $portfolio->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label" for="title">タイトル *</label>
            <input type="text" id="title" name="title" class="form-input" value="{{ old('title', $portfolio->title) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="category">カテゴリ *</label>
            <input type="text" id="category" name="category" class="form-input" value="{{ old('category', $portfolio->category) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">説明</label>
            <textarea id="description" name="description" class="form-textarea">{{ old('description', $portfolio->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="image">画像</label>
            <input type="file" id="image" name="image" class="form-input" accept="image/*">
            @if($portfolio->image_path)
            <div style="margin-top: 1rem;">
                <p style="color: rgba(255, 255, 255, 0.5); margin-bottom: 0.5rem;">現在の画像:</p>
                <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" style="max-width: 200px; border-radius: 12px;">
            </div>
            @endif
        </div>

        <div class="form-group">
            <label class="form-label" for="url">URL</label>
            <input type="url" id="url" name="url" class="form-input" value="{{ old('url', $portfolio->url) }}" placeholder="https://example.com">
        </div>

        <div class="form-group">
            <label class="form-label" for="display_order">表示順</label>
            <input type="number" id="display_order" name="display_order" class="form-input" value="{{ old('display_order', $portfolio->display_order) }}">
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $portfolio->is_published) ? 'checked' : '' }}>
                <label class="form-label" for="is_published" style="margin: 0;">公開する</label>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">更新</button>
            <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary">キャンセル</a>
        </div>
    </form>
</div>
@endsection
