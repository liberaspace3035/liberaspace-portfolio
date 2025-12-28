<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Liberaspace - 静的サイト制作からWEBアプリ開発まで、幅広いWeb制作サービスを提供">
  <title>Liberaspace | Web制作・開発サービス</title>
  <link rel="stylesheet" href="/css/main.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <!-- Navigation -->
  <nav class="nav" id="nav">
    <div class="nav-container">
      <div class="nav-logo">
        <span class="logo-text">Liberaspace</span>
        <span class="logo-dot"></span>
      </div>
      <ul class="nav-menu" id="navMenu">
        <li><a href="#home" class="nav-link active">Home</a></li>
        <li><a href="#services" class="nav-link">Services</a></li>
        <li><a href="#portfolio" class="nav-link">Portfolio</a></li>
        <li><a href="#about" class="nav-link">About</a></li>
        <li><a href="#contact" class="nav-link">Contact</a></li>
      </ul>
      <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>
  </nav>

  @yield('content')

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-brand">
          <div class="nav-logo">
            <span class="logo-text">Liberaspace</span>
            <span class="logo-dot"></span>
          </div>
          <p class="footer-description">
            静的サイトからWEBアプリまで、幅広いWeb制作サービスを提供
          </p>
        </div>
        <div class="footer-links">
          <div class="footer-column">
            <h4>サービス</h4>
            <ul>
              <li><a href="#services">静的サイト制作</a></li>
              <li><a href="#services">コーポレートサイト</a></li>
              <li><a href="#services">LP制作</a></li>
              <li><a href="#services">WEBアプリ開発</a></li>
            </ul>
          </div>
          <div class="footer-column">
            <h4>会社情報</h4>
            <ul>
              <li><a href="#about">会社について</a></li>
              <li><a href="#portfolio">制作実績</a></li>
              <li><a href="#contact">お問い合わせ</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2024 Liberaspace. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script src="/js/main.js"></script>
</body>
</html>

