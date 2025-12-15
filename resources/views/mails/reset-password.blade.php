<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Resepin</title>
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 50%, #fef2f2 100%);
            color: #374151;
            line-height: 1.6;
            padding: 40px 20px;
            min-height: 100vh;
        }
        
        /* Container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(220, 38, 38, 0.15), 0 12px 24px -8px rgba(0, 0, 0, 0.1);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            padding: 50px 30px 60px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .email-header::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
            animation: pulse 4s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        .header-decoration {
            position: absolute;
            font-size: 40px;
            opacity: 0.2;
        }
        
        .deco-1 { top: 15px; left: 20px; transform: rotate(-15deg); }
        .deco-2 { top: 20px; right: 25px; transform: rotate(20deg); }
        .deco-3 { bottom: 15px; left: 30px; transform: rotate(10deg); }
        .deco-4 { bottom: 20px; right: 20px; transform: rotate(-10deg); }
        
        .logo-wrapper {
            position: relative;
            z-index: 1;
        }
        
        .logo-icon-circle {
            width: 80px;
            height: 80px;
            margin: 0 auto 12px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }
        
        .logo-icon-circle svg {
            width: 50px;
            height: 50px;
        }
        
        .logo {
            font-size: 42px;
            font-weight: 800;
            letter-spacing: 3px;
            color: white;
            margin-bottom: 8px;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .tagline {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        /* Wave Separator */
        .wave-separator {
            height: 40px;
            background: white;
            margin-top: -40px;
            position: relative;
        }
        
        .wave-separator::before {
            content: "";
            position: absolute;
            top: -40px;
            left: 0;
            right: 0;
            height: 40px;
            background: white;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        }
        
        /* Content */
        .email-content {
            padding: 20px 40px 40px;
        }
        
        .lock-icon {
            text-align: center;
            margin-bottom: 24px;
        }
        
        .lock-icon-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-radius: 50%;
            font-size: 36px;
            box-shadow: 0 8px 24px rgba(220, 38, 38, 0.15);
            border: 3px solid #fecaca;
        }
        
        .greeting {
            font-size: 26px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
            text-align: center;
        }
        
        .greeting-subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 15px;
            margin-bottom: 28px;
        }
        
        .message-card {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 28px;
            border-left: 4px solid #dc2626;
        }
        
        .message {
            font-size: 15px;
            color: #4b5563;
            line-height: 1.8;
            margin: 0;
        }
        
        /* Button */
        .button-wrapper {
            text-align: center;
            margin: 32px 0;
        }
        
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: white !important;
            text-decoration: none;
            padding: 18px 48px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            text-align: center;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 24px rgba(220, 38, 38, 0.35), 0 4px 8px rgba(220, 38, 38, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .reset-button::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .reset-button:hover::before {
            left: 100%;
        }
        
        .reset-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(220, 38, 38, 0.4), 0 6px 12px rgba(220, 38, 38, 0.25);
        }
        
        /* Timer Info */
        .timer-box {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-radius: 12px;
            padding: 16px 20px;
            margin: 28px 0;
            border: 1px solid #fcd34d;
        }
        
        .timer-icon {
            font-size: 28px;
        }
        
        .timer-text {
            color: #92400e;
            font-size: 14px;
            font-weight: 500;
        }
        
        .timer-text strong {
            color: #78350f;
            font-weight: 700;
        }
        
        /* Warning Box */
        .warning-box {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
            border: 1px solid #fecaca;
        }
        
        .warning-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .warning-icon {
            font-size: 24px;
        }
        
        .warning-title {
            font-weight: 700;
            color: #991b1b;
            font-size: 15px;
        }
        
        .warning-text {
            color: #b91c1c;
            font-size: 14px;
            line-height: 1.6;
            padding-left: 34px;
        }
        
        /* URL Box */
        .url-section {
            margin-top: 32px;
        }
        
        .url-label {
            font-size: 13px;
            color: #6b7280;
            text-align: center;
            margin-bottom: 12px;
        }
        
        .url-box {
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 16px;
            word-break: break-all;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
            font-family: 'Courier New', monospace;
        }
        
        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 32px 0;
        }
        
        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        }
        
        .divider-icon {
            padding: 0 16px;
            font-size: 20px;
            color: #d1d5db;
        }
        
        /* Footer */
        .email-footer {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            padding: 36px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .email-footer::before {
            content: "🍳 🥘 🍜 🍰 🥗 🍲";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 60px;
            opacity: 0.03;
            white-space: nowrap;
            letter-spacing: 20px;
        }
        
        .footer-logo-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 4px;
            position: relative;
        }
        
        .footer-logo-icon {
            width: 28px;
            height: 28px;
        }
        
        .footer-logo-icon svg {
            width: 100%;
            height: 100%;
        }
        
        .footer-logo {
            font-size: 24px;
            font-weight: 800;
            color: white;
            letter-spacing: 2px;
        }
        
        .footer-tagline {
            color: rgba(255, 255, 255, 0.6);
            font-size: 12px;
            margin-bottom: 20px;
            position: relative;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 20px 0;
            flex-wrap: wrap;
            position: relative;
        }
        
        .footer-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 13px;
            padding: 8px 16px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            background: rgba(220, 38, 38, 0.8);
            color: white;
        }
        
        .footer-divider {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(220, 38, 38, 0.5), transparent);
            margin: 24px auto;
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            position: relative;
        }
        
        .footer-text a {
            color: #f87171;
            text-decoration: none;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 20px 0;
            position: relative;
        }
        
        .social-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            body {
                padding: 20px 12px;
            }
            
            .email-header {
                padding: 40px 20px 50px;
            }
            
            .header-decoration {
                font-size: 28px;
            }
            
            .logo {
                font-size: 32px;
            }
            
            .email-content {
                padding: 15px 24px 32px;
            }
            
            .greeting {
                font-size: 22px;
            }
            
            .reset-button {
                padding: 16px 36px;
                font-size: 15px;
            }
            
            .message-card {
                padding: 18px;
            }
            
            .footer-links {
                gap: 6px;
            }
            
            .footer-link {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <!-- Decorative Food Icons -->
            <span class="header-decoration deco-1">🍳</span>
            <span class="header-decoration deco-2">🥘</span>
            <span class="header-decoration deco-3">🍜</span>
            <span class="header-decoration deco-4">🍰</span>
            
            <div class="logo-wrapper">
                <div class="logo-icon-circle">
                    <!-- SVG Salad/Bowl Icon -->
                    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <!-- Bowl -->
                        <ellipse cx="32" cy="44" rx="24" ry="10" fill="#dc2626"/>
                        <path d="M8 38c0 8 10.7 14 24 14s24-6 24-14" stroke="#b91c1c" stroke-width="2" fill="none"/>
                        <ellipse cx="32" cy="38" rx="24" ry="8" fill="#ef4444"/>
                        <!-- Salad/Food -->
                        <ellipse cx="32" cy="36" rx="18" ry="6" fill="#22c55e"/>
                        <circle cx="24" cy="34" r="4" fill="#f97316"/>
                        <circle cx="38" cy="33" r="3" fill="#eab308"/>
                        <circle cx="32" cy="32" r="3" fill="#ef4444"/>
                        <circle cx="28" cy="36" r="2" fill="#a855f7"/>
                        <!-- Leaf decoration -->
                        <path d="M32 24c-4 0-6 4-6 8 6-2 10-4 12-8-2 0-4 0-6 0z" fill="#16a34a"/>
                        <path d="M32 24c4 0 6 4 6 8-6-2-10-4-12-8 2 0 4 0 6 0z" fill="#15803d"/>
                    </svg>
                </div>
                <div class="logo">RESEPIN</div>
                <p class="tagline">Temukan & Bagikan Resep Favoritmu</p>
            </div>
        </div>
        
        <!-- Wave Separator -->
        <div class="wave-separator"></div>
        
        <!-- Content -->
        <div class="email-content">
            <!-- Lock Icon -->
            <div class="lock-icon">
                <div class="lock-icon-circle">🔐</div>
            </div>
            
            <h1 class="greeting">Halo, {{ $user->name ?? 'Pengguna' }}! 👋</h1>
            <p class="greeting-subtitle">Ada permintaan untuk reset password akunmu</p>
            
            <div class="message-card">
                <p class="message">
                    Seseorang (mudah-mudahan kamu!) telah meminta untuk mereset password akun Resepin yang terhubung dengan email ini. Jika memang kamu yang memintanya, klik tombol di bawah untuk membuat password baru.
                </p>
            </div>
            
            <div class="button-wrapper">
                <a href="{{ $url }}" class="reset-button">
                    ✨ Reset Password Sekarang
                </a>
            </div>
            
            <!-- Timer Info -->
            <div class="timer-box">
                <span class="timer-icon">⏱️</span>
                <span class="timer-text">Link berlaku selama <strong>60 menit</strong> dari sekarang</span>
            </div>
            
            <div class="warning-box">
                <div class="warning-header">
                    <span class="warning-icon">🛡️</span>
                    <span class="warning-title">Bukan kamu yang meminta?</span>
                </div>
                <p class="warning-text">
                    Tenang saja! Abaikan email ini dan passwordmu akan tetap aman. Tidak ada perubahan yang akan terjadi pada akunmu.
                </p>
            </div>
            
            <!-- Divider -->
            <div class="divider">
                <div class="divider-line"></div>
                <span class="divider-icon">🍴</span>
                <div class="divider-line"></div>
            </div>
            
            <div class="url-section">
                <p class="url-label">Atau salin link berikut ke browser:</p>
                <div class="url-box">{{ $url }}</div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-logo-wrapper">
                <span class="footer-logo-icon">
                    <!-- SVG Salad Icon (White) -->
                    <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <ellipse cx="32" cy="44" rx="24" ry="10" fill="rgba(255,255,255,0.9)"/>
                        <ellipse cx="32" cy="38" rx="24" ry="8" fill="white"/>
                        <ellipse cx="32" cy="36" rx="18" ry="6" fill="rgba(255,255,255,0.7)"/>
                        <circle cx="24" cy="34" r="4" fill="rgba(255,255,255,0.5)"/>
                        <circle cx="38" cy="33" r="3" fill="rgba(255,255,255,0.5)"/>
                        <circle cx="32" cy="32" r="3" fill="rgba(255,255,255,0.6)"/>
                    </svg>
                </span>
                <span class="footer-logo">RESEPIN</span>
            </div>
            <div class="footer-tagline">Masak Jadi Lebih Mudah & Menyenangkan!</div>
            
            <div class="footer-links">
                <a href="{{ url('/') }}" class="footer-link">🏠 Beranda</a>
                <a href="{{ url('/recipes') }}" class="footer-link">📖 Resep</a>
                <a href="{{ url('/about') }}" class="footer-link">ℹ️ Tentang</a>
                <a href="{{ url('/contact') }}" class="footer-link">📧 Kontak</a>
            </div>
            
            <div class="social-icons">
                <a href="#" class="social-icon">📘</a>
                <a href="#" class="social-icon">📸</a>
                <a href="#" class="social-icon">🐦</a>
                <a href="#" class="social-icon">▶️</a>
            </div>
            
            <div class="footer-divider"></div>
            
            <p class="footer-text">
                © {{ date('Y') }} Resepin. Dibuat dengan ❤️ di Indonesia<br>
                <small style="opacity: 0.7;">
                    Email ini dikirim otomatis. Mohon jangan membalas email ini.
                </small>
            </p>
        </div>
    </div>
</body>
</html>