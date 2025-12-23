@extends('admin.layout')

@section('title', 'サービス追加')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">サービスを追加</h1>
    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">戻る</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.services.store') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="title">タイトル *</label>
            <input type="text" id="title" name="title" class="form-input" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">説明 *</label>
            <textarea id="description" name="description" class="form-textarea" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="icon_svg">SVGアイコンコード *</label>
            <textarea id="icon_svg" name="icon_svg" class="form-textarea" rows="5" required placeholder='<svg width="32" height="32" viewBox="0 0 32 32" fill="none">...</svg>'>{{ old('icon_svg') }}</textarea>
            <p style="color: rgba(255, 255, 255, 0.5); font-size: 0.875rem; margin-top: 0.5rem;">
                SVGコードをそのまま貼り付けてください
            </p>
        </div>

        <div class="form-group">
            <label class="form-label" for="features">特徴（改行区切り） *</label>
            <textarea id="features" name="features" class="form-textarea" rows="5" required placeholder="HTML / CSS / JavaScript&#10;レスポンシブ対応&#10;SEO最適化">{{ old('features') }}</textarea>
            <p style="color: rgba(255, 255, 255, 0.5); font-size: 0.875rem; margin-top: 0.5rem;">
                1行に1つの特徴を入力してください
            </p>
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
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">キャンセル</a>
        </div>
    </form>
</div>
@endsection

