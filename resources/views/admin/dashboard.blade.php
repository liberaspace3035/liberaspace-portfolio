@extends('admin.layout')

@section('title', 'ダッシュボード')

@section('content')
<div class="admin-header">
    <h1 class="admin-title">ダッシュボード</h1>
</div>

<div class="grid grid-cols-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">制作実績</h3>
        </div>
        <div style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">{{ $portfolios->count() }}</div>
        <a href="{{ route('admin.portfolios.index') }}" class="btn btn-secondary" style="width: 100%; justify-content: center;">管理する</a>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">実績数字</h3>
        </div>
        <div style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">{{ $heroStats->count() ?? 0 }}</div>
        <a href="{{ route('admin.hero-stats.index') }}" class="btn btn-secondary" style="width: 100%; justify-content: center;">管理する</a>
    </div>
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">サービス</h3>
        </div>
        <div style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">{{ $services->count() ?? 0 }}</div>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary" style="width: 100%; justify-content: center;">管理する</a>
    </div>
</div>
@endsection
