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
            background-color: #f8fafc;
            color: #374151;
            line-height: 1.5;
            padding: 20px;
        }
        
        /* Container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            padding: 40px 30px;
            text-align: center;
            border-bottom: 3px solid #dc2626;
        }
        
        .logo {
            font-size: 48px;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: #dc2626;
            margin-bottom: 8px;
        }
        
        .tagline {
            font-size: 18px;
            color: #6b7280;
            font-weight: 500;
        }
        
        /* Content */
        .email-content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 24px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 24px;
        }
        
        .message {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 32px;
            line-height: 1.7;
        }
        
        /* Button */
        .reset-button {
            display: inline-block;
            background: linear-gradient(to right, #dc2626, #ef4444);
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(220, 38, 38, 0.2);
        }
        
        .reset-button:hover {
            background: linear-gradient(to right, #b91c1c, #dc2626);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3);
        }
        
        /* Warning Box */
        .warning-box {
            background-color: #fffbeb;
            border: 1px solid #fcd34d;
            border-radius: 8px;
            padding: 16px;
            margin: 24px 0;
        }
        
        .warning-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: #92400e;
            margin-bottom: 8px;
        }
        
        .warning-text {
            color: #92400e;
            font-size: 14px;
        }
        
        /* URL Box */
        .url-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 16px;
            margin: 24px 0;
            word-break: break-all;
            font-size: 14px;
            color: #6b7280;
        }
        
        /* Footer */
        .email-footer {
            background-color: #f9fafb;
            padding: 24px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer-text {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 16px;
        }
        
        .footer-link {
            color: #dc2626;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }
        
        .footer-link:hover {
            color: #b91c1c;
            text-decoration: underline;
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .email-header {
                padding: 30px 20px;
            }
            
            .email-content {
                padding: 30px 20px;
            }
            
            .logo {
                font-size: 36px;
            }
            
            .reset-button {
                width: 100%;
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <div class="logo">RESEPIN</div>
            <p class="tagline">Temukan & Bagikan Resep Favoritmu</p>
        </div>
        
        <!-- Content -->
        <div class="email-content">
            <h1 class="greeting">Halo, {{ $user->name ?? 'Pengguna' }}! 👋</h1>
            
            <p class="message">
                Kami menerima permintaan reset password untuk akun Resepin kamu. 
                Klik tombol di bawah untuk melanjutkan proses reset password.
            </p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="reset-button">
                    🔐 Reset Password
                </a>
            </div>
            
            <div class="warning-box">
                <div class="warning-title">
                    ⏰
                    <span>Penting!</span>
                </div>
                <p class="warning-text">
                    Link ini hanya berlaku selama <strong>60 menit</strong>. 
                    Jika kamu tidak merasa meminta reset password, silakan abaikan email ini.
                </p>
            </div>
            
            <p class="message">
                Jika tombol di atas tidak berfungsi, salin dan tempel URL berikut di browser Anda:
            </p>
            
            <div class="url-box">
                {{ $url }}
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p class="footer-text">
                Salam hangat,<br>
                <strong>Tim Resepin</strong> 🍲
            </p>
            
            <div class="footer-links">
                <a href="{{ url('/') }}" class="footer-link">Beranda</a>
                <a href="{{ url('/recipes') }}" class="footer-link">Resep</a>
                <a href="{{ url('/about') }}" class="footer-link">Tentang Kami</a>
                <a href="{{ url('/contact') }}" class="footer-link">Kontak</a>
            </div>
            
            <p class="footer-text" style="margin-top: 20px;">
                © {{ date('Y') }} Resepin. Semua hak dilindungi.<br>
                <small style="color: #9ca3af;">
                    Email ini dikirim karena adanya permintaan reset password di akun Resepin.
                </small>
            </p>
        </div>
    </div>
</body>
</html>