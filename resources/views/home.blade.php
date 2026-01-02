@extends('layouts.app')

@section('content')
  <!-- Hero Section -->
  <section id="home" class="hero">
    <div class="hero-background">
      <div class="gradient-orb orb-1"></div>
      <div class="gradient-orb orb-2"></div>
      <div class="gradient-orb orb-3"></div>
      <canvas id="particleCanvas" class="particle-canvas"></canvas>
    </div>
    <div class="hero-content">
      <div class="hero-badge">
        <span class="badge-text">Web制作のプロフェッショナル</span>
        <div class="badge-glow"></div>
      </div>
      <h1 class="hero-title">
        <span class="title-line">あなたのビジネスを</span>
        <span class="title-line highlight">デジタルで支援</span>
        <span class="title-line">します</span>
      </h1>
      <p class="hero-description">
        静的サイトからWEBアプリまで、幅広いWeb制作サービスを提供。<br>
        豊富な実績と技術力で、お客様のビジネス成長をサポートします。
      </p>
      <div class="hero-actions">
        <a href="#portfolio" class="btn btn-primary">
          <span>実績を見る</span>
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        <a href="#contact" class="btn btn-secondary">
          <span>お問い合わせ</span>
        </a>
      </div>
      <div class="hero-stats">
        @forelse($heroStats as $stat)
        <div class="stat-item">
          <div class="stat-number" data-target="{{ $stat->value }}">0</div>
          <div class="stat-label">{{ $stat->label }}</div>
        </div>
        @empty
        <div class="stat-item">
          <div class="stat-number" data-target="20">0</div>
          <div class="stat-label">案件実績</div>
        </div>
        <div class="stat-item">
          <div class="stat-number" data-target="10">0</div>
          <div class="stat-label">コーポレートサイト</div>
        </div>
        <div class="stat-item">
          <div class="stat-number" data-target="3">0</div>
          <div class="stat-label">WEBアプリ</div>
        </div>
        @endforelse
      </div>
    </div>
    <div class="scroll-hint">
      <div class="scroll-line"></div>
      <span>Scroll</span>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="services">
    <div class="container">
      <div class="section-header">
        <span class="section-label">サービス内容</span>
        <h2 class="section-title">提供サービス</h2>
        <p class="section-description">
          静的サイトからWEBアプリまで、幅広いWeb制作サービスでお客様のビジネスをサポート
        </p>
      </div>
      <div class="services-grid">
        @forelse($services as $service)
        <div class="service-card">
          <div class="service-icon">
            {!! $service->icon_svg !!}
          </div>
          <h3 class="service-title">{{ $service->title }}</h3>
          <p class="service-description">
            {{ $service->description }}
          </p>
          @if($service->features && is_array($service->features))
          <ul class="service-features">
            @foreach($service->features as $feature)
            <li>{{ $feature }}</li>
            @endforeach
          </ul>
          @endif
        </div>
        @empty
        <div class="service-card">
          <div class="service-icon">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
              <path d="M16 2L4 8V16C4 22.6 9.4 28 16 28C22.6 28 28 22.6 28 16V8L16 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M16 16L10 13M16 16L22 13M16 16V22" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <h3 class="service-title">静的サイト制作</h3>
          <p class="service-description">
            高速で軽量な静的サイトを制作。SEO対策も万全で、検索エンジンでの上位表示をサポートします。
          </p>
          <ul class="service-features">
            <li>HTML / CSS / JavaScript</li>
            <li>レスポンシブ対応</li>
            <li>SEO最適化</li>
          </ul>
        </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- Portfolio Section -->
  <section id="portfolio" class="portfolio">
    <div class="container">
      <div class="section-header">
        <span class="section-label">実績</span>
        <h2 class="section-title">制作実績</h2>
        <p class="section-description">
          これまでに制作したプロジェクトの一部をご紹介します
        </p>
      </div>
      <div class="portfolio-grid">
        @forelse($portfolios as $portfolio)
        <div class="portfolio-item">
          <div class="portfolio-image">
            <img src="{{ $portfolio->image_url }}" alt="{{ $portfolio->title }}" loading="lazy">
            <div class="portfolio-overlay">
              <div class="portfolio-content">
                <h3 class="portfolio-title">{{ $portfolio->title }}</h3>
                <p class="portfolio-category">{{ $portfolio->category }}</p>
                @if($portfolio->url)
                <a href="{{ $portfolio->url }}" target="_blank" rel="noopener noreferrer" class="portfolio-link">
                  <span>詳細を見る</span>
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M5 15L15 5M15 5H5M15 5V15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </a>
                @endif
              </div>
            </div>
          </div>
        </div>
        @empty
        <div class="portfolio-item">
          <div class="portfolio-image">
            <p style="text-align: center; padding: 2rem; color: rgba(255, 255, 255, 0.5);">制作実績がまだありません</p>
          </div>
        </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="about">
    <div class="container">
      <div class="about-content">
        <div class="about-text">
          <span class="section-label">会社について</span>
          <h2 class="section-title">Liberaspaceについて</h2>
          <div class="about-description">
            <p>
              Liberaspaceは、静的サイト制作からWEBアプリ開発まで、幅広いWeb制作サービスを提供する会社です。
              お客様のビジネス成長をサポートする、質の高いWebソリューションを提供しています。
            </p>
            <p>
              これまでに、コーポレートサイト制作10社以上、LP制作10社以上、WEBアプリ開発3件など、
              様々な規模のプロジェクトに携わってきました。案件経験数は20件以上にのぼります。
            </p>
            <p>
              Laravel、PHP、JavaScript、MySQLを中心とした技術スタックで、
              WordPressやWIXなどのCMSも活用し、お客様のニーズに最適なソリューションを提案します。
            </p>
          </div>
          <div class="about-stats">
            @forelse($heroStats as $stat)
            <div class="about-stat">
              <div class="stat-number" data-target="{{ $stat->value }}">0</div>
              <div class="about-stat-label">{{ $stat->label }}</div>
            </div>
            @empty
            <div class="about-stat">
              <div class="stat-number" data-target="20">0</div>
              <div class="about-stat-label">案件実績</div>
            </div>
            <div class="about-stat">
              <div class="stat-number" data-target="10">0</div>
              <div class="about-stat-label">コーポレートサイト</div>
            </div>
            <div class="about-stat">
              <div class="stat-number" data-target="3">0</div>
              <div class="about-stat-label">WEBアプリ</div>
            </div>
            @endforelse
          </div>
        </div>
        <div class="about-visual">
          <div class="about-card">
            <div class="card-glow"></div>
            <div class="card-content">
              <h3>技術スタック</h3>
              <ul class="values-list">
                <li>
                  <span class="value-icon">💻</span>
                  <div>
                    <strong>Laravel / PHP</strong>
                    <p>WEBアプリ開発の基盤</p>
                  </div>
                </li>
                <li>
                  <span class="value-icon">🌐</span>
                  <div>
                    <strong>JavaScript / MySQL</strong>
                    <p>フロントエンドとデータベース</p>
                  </div>
                </li>
                <li>
                  <span class="value-icon">📝</span>
                  <div>
                    <strong>WordPress / WIX / CMS</strong>
                    <p>CMS活用による効率的な制作</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact">
    <div class="container">
      <div class="contact-content">
        <div class="contact-info">
          <span class="section-label">お問い合わせ</span>
          <h2 class="section-title">お気軽にご相談ください</h2>
          <p class="contact-description">
            プロジェクトのご相談やお見積もりなど、お気軽にお問い合わせください。
            通常、24時間以内にご返信いたします。
          </p>
          <div class="contact-details">
            <div class="contact-item">
              <div class="contact-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div>
                <h4>Email</h4>
                <a href="mailto:info@liberaspace.com">info@liberaspace.com</a>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M22 16.92V19.92C22 20.52 21.52 21 20.92 21C9.4 21 0 11.6 0 0.08C0 -0.52 0.48 -1 1.08 -1H4.08C4.68 -1 5.16 -0.52 5.16 0.08V3.08C5.16 3.68 4.68 4.16 4.08 4.16H1.08C1.08 8.28 4.72 11.92 8.84 11.92V8.92C8.84 8.32 9.32 7.84 9.92 7.84H12.92C13.52 7.84 14 8.32 14 8.92V11.92C14 16.04 17.64 19.68 21.76 19.68H18.76C18.16 19.68 17.68 20.16 17.68 20.76V23.76C17.68 24.36 18.16 24.84 18.76 24.84H21.76C22.36 24.84 22.84 24.36 22.84 23.76V20.76" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div>
                <h4>Phone</h4>
                <a href="tel:+81312345678">+81 3-1234-5678</a>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61 4.61 6 7 6C8.5 6 9.87 6.69 10.71 7.71L12 9L13.29 7.71C14.13 6.69 15.5 6 17 6C19.39 6 21 7.61 21 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
              <div>
                <h4>Location</h4>
                <p>Tokyo, Japan</p>
              </div>
            </div>
          </div>
          <div class="social-links">
            <a href="#" class="social-link" aria-label="GitHub">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M9 19C4 20.5 4 16.5 2 16M22 16V19C22 19.5 21.5 20 21 20H3C2.5 20 2 19.5 2 19V16C2 13.5 4 12 6 12C6.5 12 7 12.5 7 13V14C7 14.5 7.5 15 8 15H16C16.5 15 17 14.5 17 14V13C17 12.5 17.5 12 18 12C20 12 22 13.5 22 16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <a href="#" class="social-link" aria-label="Twitter">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M23 3C22.1 3.4 21.2 3.7 20.2 3.9C21.2 3.3 22 2.3 22.4 1.1C21.4 1.7 20.3 2.1 19.1 2.3C18.1 1.3 16.7 0.7 15.1 0.7C12.6 0.7 10.6 2.7 10.6 5.2C10.6 5.5 10.6 5.8 10.7 6.1C7 5.9 3.7 4.1 1.5 1.4C1.2 1.9 1 2.4 1 3C1 4 1.5 4.9 2.3 5.4C1.5 5.4 0.7 5.2 0 4.9C0 4.9 0 4.9 0 5C0 7.1 1.4 8.9 3.3 9.3C3 9.4 2.7 9.4 2.4 9.4C2.2 9.4 2 9.4 1.8 9.3C2.2 11.1 3.8 12.4 5.7 12.4C4.2 13.5 2.4 14.1 0.5 14.1C0.2 14.1 0 14.1 0 14.1C1.5 15.3 3.3 16 5.2 16C15.1 16 19.6 9.5 19.6 3.8C19.6 3.6 19.6 3.4 19.6 3.2C20.6 2.5 21.4 1.7 22 0.8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </a>
            <a href="#" class="social-link" aria-label="LinkedIn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M16 8C17.5913 8 19.1174 8.63214 20.2426 9.75736C21.3679 10.8826 22 12.4087 22 14V21H18V14C18 13.4696 17.7893 12.9609 17.4142 12.5858C17.0391 12.2107 16.5304 12 16 12C15.4696 12 14.9609 12.2107 14.5858 12.5858C14.2107 12.9609 14 13.4696 14 14V21H10V14C10 12.4087 10.6321 10.8826 11.7574 9.75736C12.8826 8.63214 14.4087 8 16 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M6 9H2V21H6V9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="4" cy="4" r="2" stroke="currentColor" stroke-width="2"/>
              </svg>
            </a>
          </div>
        </div>
        <div class="contact-form-wrapper">
          <form class="contact-form" id="contactForm">
            <div class="form-group">
              <label for="name">お名前</label>
              <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
              <label for="email">メールアドレス</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="subject">件名</label>
              <input type="text" id="subject" name="subject" required>
            </div>
            <div class="form-group">
              <label for="message">メッセージ</label>
              <textarea id="message" name="message" rows="6" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
              <span>送信する</span>
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M2.5 17.5L17.5 2.5M17.5 2.5H7.5M17.5 2.5V12.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
@endsection

