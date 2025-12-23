<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '管理画面') - Liberaspace CMS</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .admin-container {
            min-height: 100vh;
            background: #0a0a0f;
            color: #ffffff;
        }
        .admin-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: #111118;
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            padding: 2rem;
            overflow-y: auto;
        }
        .admin-logo {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .admin-logo-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
        }
        .admin-nav {
            list-style: none;
        }
        .admin-nav-item {
            margin-bottom: 0.5rem;
        }
        .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .admin-nav-link:hover,
        .admin-nav-link.active {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border-left: 2px solid #6366f1;
        }
        .admin-main {
            margin-left: 280px;
            padding: 2rem;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .admin-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
            color: #ffffff;
            box-shadow: 0 0 40px rgba(99, 102, 241, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 60px rgba(99, 102, 241, 0.5);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: #6366f1;
        }
        .btn-danger {
            background: #f56565;
            color: #ffffff;
        }
        .btn-danger:hover {
            background: #e53e3e;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(16px);
        }
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .card-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: #ffffff;
        }
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }
        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #10b981;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .form-input,
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s;
        }
        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .checkbox-group input {
            width: auto;
        }
        .grid {
            display: grid;
            gap: 1.5rem;
        }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            .admin-main {
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <span>Liberaspace</span>
                <span class="admin-logo-dot"></span>
            </div>
            <nav>
                <ul class="admin-nav">
                    <li class="admin-nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span>📊</span>
                            <span>ダッシュボード</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="{{ route('admin.portfolios.index') }}" class="admin-nav-link {{ request()->routeIs('admin.portfolios.*') ? 'active' : '' }}">
                            <span>🎨</span>
                            <span>制作実績</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="{{ route('admin.hero-stats.index') }}" class="admin-nav-link {{ request()->routeIs('admin.hero-stats.*') ? 'active' : '' }}">
                            <span>📈</span>
                            <span>実績数字</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="{{ route('admin.services.index') }}" class="admin-nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                            <span>⚙️</span>
                            <span>サービス</span>
                        </a>
                    </li>
                    <li class="admin-nav-item">
                        <a href="{{ route('admin.logout') }}" class="admin-nav-link">
                            <span>🚪</span>
                            <span>ログアウト</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>
        <main class="admin-main">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>

