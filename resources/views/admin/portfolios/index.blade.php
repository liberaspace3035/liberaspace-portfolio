@extends('admin.layout')

@section('title', '制作実績管理')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">制作実績管理</h1>
    <a href="{{ route('admin.portfolios.create') }}" class="btn btn-primary">新規追加</a>
</div>

<div class="grid grid-cols-1">
    @forelse($portfolios as $portfolio)
    <div class="card">
        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 1.5rem;">
            @if($portfolio->image_path)
            <div>
                <img src="{{ asset('storage/' . $portfolio->image_path) }}" alt="{{ $portfolio->title }}" style="width: 100%; height: 150px; object-fit: cover; border-radius: 12px;">
            </div>
            @endif
            <div>
                <div class="card-header" style="padding: 0; margin-bottom: 1rem;">
                    <div>
                        <h3 class="card-title">{{ $portfolio->title }}</h3>
                        <p style="color: rgba(255, 255, 255, 0.5); margin-top: 0.5rem;">
                            カテゴリ: {{ $portfolio->category }} | 
                            表示順: {{ $portfolio->display_order }} | 
                            公開状態: {{ $portfolio->is_published ? '公開' : '非公開' }}
                        </p>
                    </div>
                    <div style="display: flex; gap: 0.75rem;">
                        <a href="{{ route('admin.portfolios.edit', $portfolio->id) }}" class="btn btn-secondary">編集</a>
                        <form method="POST" action="{{ route('admin.portfolios.destroy', $portfolio->id) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('削除してもよろしいですか？')">削除</button>
                        </form>
                    </div>
                </div>
                @if($portfolio->description)
                <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 1rem;">{{ Str::limit($portfolio->description, 150) }}</p>
                @endif
                @if($portfolio->url)
                <a href="{{ $portfolio->url }}" target="_blank" style="color: #6366f1; text-decoration: none;">{{ $portfolio->url }}</a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="card">
        <p style="color: rgba(255, 255, 255, 0.5); text-align: center; padding: 2rem;">
            制作実績がありません。<a href="{{ route('admin.portfolios.create') }}" style="color: #6366f1;">新規追加</a>してください。
        </p>
    </div>
    @endforelse
</div>
@endsection
