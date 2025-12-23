<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面ログイン - Liberaspace</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #0a0a0f;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 3rem;
            backdrop-filter: blur(16px);
            max-width: 400px;
            width: 100%;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }
        .login-logo {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
        }
        .login-logo-dot {
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
        h1 {
            color: #ffffff;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
            text-align: center;
        }
        p {
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 2rem;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .error {
            color: #f56565;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        button {
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 0 40px rgba(99, 102, 241, 0.3);
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 60px rgba(99, 102, 241, 0.5);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo">
            <span>Liberaspace</span>
            <span class="login-logo-dot"></span>
        </div>
        <h1>管理画面ログイン</h1>
        <p>制作実績管理システム</p>
        
        @if($errors->any())
            <div class="error" style="margin-bottom: 1rem;">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" required autofocus>
            </div>
            <button type="submit">ログイン</button>
        </form>
    </div>
</body>
</html>
