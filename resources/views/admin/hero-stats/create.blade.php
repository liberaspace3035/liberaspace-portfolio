@extends('admin.layout')

@section('title', '実績数字追加')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">実績数字を追加</h1>
    <a href="{{ route('admin.hero-stats.index') }}" class="btn btn-secondary">戻る</a>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.hero-stats.store') }}">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="label">ラベル *</label>
            <input type="text" id="label" name="label" class="form-input" value="{{ old('label') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="value">数値 *</label>
            <input type="number" id="value" name="value" class="form-input" value="{{ old('value') }}" min="0" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="display_order">表示順</label>
            <input type="number" id="display_order" name="display_order" class="form-input" value="{{ old('display_order', 0) }}">
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">保存</button>
            <a href="{{ route('admin.hero-stats.index') }}" class="btn btn-secondary">キャンセル</a>
        </div>
    </form>
</div>
@endsection



