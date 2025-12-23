@extends('admin.layout')

@section('title', 'サービス編集')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">サービスを編集</h1>
    <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">戻る</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.services.update', $service->id) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label" for="title">タイトル *</label>
            <input type="text" id="title" name="title" class="form-input" value="{{ old('title', $service->title) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">説明 *</label>
            <textarea id="description" name="description" class="form-textarea" required>{{ old('description', $service->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="icon_svg">SVGアイコンコード *</label>
            <textarea id="icon_svg" name="icon_svg" class="form-textarea" rows="5" required>{{ old('icon_svg', $service->icon_svg) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="features">特徴（改行区切り） *</label>
            <textarea id="features" name="features" class="form-textarea" rows="5" required>{{ old('features', $service->features_display ?? (is_array($service->features) ? implode("\n", $service->features) : $service->features)) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="display_order">表示順</label>
            <input type="number" id="display_order" name="display_order" class="form-input" value="{{ old('display_order', $service->display_order) }}">
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $service->is_published) ? 'checked' : '' }}>
                <label class="form-label" for="is_published" style="margin: 0;">公開する</label>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">更新</button>
            <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">キャンセル</a>
        </div>
    </form>
</div>
@endsection

