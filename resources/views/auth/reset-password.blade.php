<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password</title>
  <link rel="stylesheet" href="{{ asset('assets/loginpage.css') }}" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #ff6b6b 0%, #ff8c42 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
    }

    .reset-container {
      width: 100%;
      max-width: 420px;
      padding: 20px;
    }

    .reset-box {
      background: white;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
      animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .reset-box h1 {
      text-align: center;
      color: #333;
      margin-bottom: 10px;
      font-size: 28px;
      font-weight: 600;
    }

    .reset-box .description {
      text-align: center;
      color: #666;
      font-size: 13px;
      margin-bottom: 25px;
      line-height: 1.6;
    }

    .input-box {
      position: relative;
      margin-bottom: 20px;
      border-bottom: 2px solid #eee;
      transition: border-color 0.3s;
    }

    .input-box input {
      width: 100%;
      background: transparent;
      border: none;
      outline: none;
      padding: 12px 0;
      padding-left: 5px;
      font-size: 14px;
      color: #333;
      font-family: 'Poppins', sans-serif;
    }

    .input-box input::placeholder {
      color: #aaa;
    }

    .input-box i {
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      color: #ff6b6b;
      font-size: 18px;
    }

    .input-box:focus-within {
      border-bottom-color: #ff6b6b;
    }

    .alert-error {
      background-color: #fee2e2;
      border-left: 4px solid #ef4444;
      color: #7f1d1d;
      padding: 12px 16px;
      border-radius: 8px;
      margin-bottom: 15px;
      font-size: 13px;
      line-height: 1.5;
    }

    .btn {
      width: 100%;
      background: #ff6b6b;
      border: none;
      outline: none;
      border-radius: 8px;
      padding: 12px;
      color: white;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 10px;
      font-family: 'Poppins', sans-serif;
    }

    .btn:hover {
      background: #ff5252;
      transform: translateY(-2px);
      box-shadow: 0 5px 20px rgba(255, 107, 107, 0.4);
    }

    .reset-box p {
      text-align: center;
      color: #666;
      margin-top: 15px;
      font-size: 13px;
    }

    .reset-box p a {
      color: #ff6b6b;
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
    }

    .reset-box p a:hover {
      color: #ff5252;
      text-decoration: underline;
    }

    .back-link {
      text-align: center;
      margin-top: 20px;
    }

    .back-link a {
      color: white;
      text-decoration: none;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 5px;
      transition: all 0.3s;
    }

    .back-link a:hover {
      gap: 10px;
    }

    .back-link svg {
      width: 18px;
      height: 18px;
    }
  </style>
</head>
<body>
  <div class="reset-container">
    <div class="reset-box">
      <h1>🔑 Reset Password</h1>
      <div class="description">
        Masukkan password baru Anda untuk mereset akun.
      </div>

      <form id="resetForm" method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="input-box">
          <input 
            type="email" 
            name="email" 
            placeholder="Alamat Email" 
            value="{{ old('email', $request->email) }}" 
            required 
          />
          <i class='bx bxs-envelope'></i>
        </div>

        @if ($errors->has('email'))
          <div class="alert-error">
            ✕ {{ $errors->first('email') }}
          </div>
        @endif

        <div class="input-box">
          <input 
            type="password" 
            name="password" 
            placeholder="Password Baru" 
            required 
          />
          <i class='bx bxs-lock-alt'></i>
        </div>

        @if ($errors->has('password'))
          <div class="alert-error">
            ✕ {{ $errors->first('password') }}
          </div>
        @endif

        <div class="input-box">
          <input 
            type="password" 
            name="password_confirmation" 
            placeholder="Konfirmasi Password" 
            required 
          />
          <i class='bx bxs-lock'></i>
        </div>

        @if ($errors->has('password_confirmation'))
          <div class="alert-error">
            ✕ {{ $errors->first('password_confirmation') }}
          </div>
        @endif

        <button type="submit" class="btn">Reset Password</button>
      </form>

      <p>Ingat passwordmu? <a href="{{ route('login') }}">Login di sini</a></p>
    </div>

    <div class="back-link">
      <a href="/">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Dashboard
      </a>
    </div>
  </div>

  <script src="{{ asset('assets/loginpage.js') }}"></script>
</body>
</html>
