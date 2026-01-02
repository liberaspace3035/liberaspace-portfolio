@extends('admin.layout')

@section('title', '実績数字管理')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">実績数字管理</h1>
    <a href="{{ route('admin.hero-stats.create') }}" class="btn btn-primary">新規追加</a>
</div>

<div class="grid grid-cols-1">
    @forelse($stats as $stat)
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">{{ $stat->label }}</h3>
                <p style="color: rgba(255, 255, 255, 0.5); margin-top: 0.5rem;">表示順: {{ $stat->display_order }}</p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('admin.hero-stats.edit', $stat->id) }}" class="btn btn-secondary">編集</a>
                <form method="POST" action="{{ route('admin.hero-stats.destroy', $stat->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('削除してもよろしいですか？')">削除</button>
                </form>
            </div>
        </div>
        <div style="font-size: 3rem; font-weight: 700; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
            {{ $stat->value }}
        </div>
    </div>
    @empty
    <div class="card">
        <p style="color: rgba(255, 255, 255, 0.5); text-align: center; padding: 2rem;">
            実績数字がありません。<a href="{{ route('admin.hero-stats.create') }}" style="color: #6366f1;">新規追加</a>してください。
        </p>
    </div>
    @endforelse
</div>
@endsection



