@extends('admin.layout')

@section('title', 'サービス管理')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">サービス管理</h1>
    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">新規追加</a>
</div>

<div class="grid grid-cols-1">
    @forelse($services as $service)
    <div class="card">
        <div class="card-header">
            <div>
                <h3 class="card-title">{{ $service->title }}</h3>
                <p style="color: rgba(255, 255, 255, 0.5); margin-top: 0.5rem;">
                    表示順: {{ $service->display_order }} | 
                    公開状態: {{ $service->is_published ? '公開' : '非公開' }}
                </p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-secondary">編集</a>
                <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('削除してもよろしいですか？')">削除</button>
                </form>
            </div>
        </div>
        <div style="margin-top: 1rem;">
            <div style="margin-bottom: 1rem; width: 32px; height: 32px; color: #6366f1;">{!! $service->icon_svg !!}</div>
            <p style="color: rgba(255, 255, 255, 0.7); margin-bottom: 1rem;">{{ $service->description }}</p>
            @if($service->features && is_array($service->features))
            <ul style="list-style: none; padding: 0;">
                @foreach($service->features as $feature)
                <li style="padding: 0.5rem 0; color: rgba(255, 255, 255, 0.6);">• {{ $feature }}</li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
    @empty
    <div class="card">
        <p style="color: rgba(255, 255, 255, 0.5); text-align: center; padding: 2rem;">
            サービスがありません。<a href="{{ route('admin.services.create') }}" style="color: #6366f1;">新規追加</a>してください。
        </p>
    </div>
    @endforelse
</div>
@endsection

