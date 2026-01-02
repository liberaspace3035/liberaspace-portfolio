@extends('admin.layout')

@section('title', '実績数字編集')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">実績数字を編集</h1>
    <a href="{{ route('admin.hero-stats.index') }}" class="btn btn-secondary">戻る</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.hero-stats.update', $stat->id) }}">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label" for="label">ラベル *</label>
            <input type="text" id="label" name="label" class="form-input" value="{{ old('label', $stat->label) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="value">数値 *</label>
            <input type="number" id="value" name="value" class="form-input" value="{{ old('value', $stat->value) }}" min="0" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="display_order">表示順</label>
            <input type="number" id="display_order" name="display_order" class="form-input" value="{{ old('display_order', $stat->display_order) }}">
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">更新</button>
            <a href="{{ route('admin.hero-stats.index') }}" class="btn btn-secondary">キャンセル</a>
        </div>
    </form>
</div>
@endsection



