<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login/Signup Form</title>
  <link rel="stylesheet" href="{{ asset('assets/loginpage.css') }}" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container">
    <!-- Login Form -->
    <div class="form-box login">
      <form id="loginForm" method="POST" action="{{ route('login') }}">
          @csrf
          <h1>Login</h1>
          <div class="input-box">
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
            <i class='bx bxs-user'></i>
          </div>
          <div class="input-box">
            <input type="password" name="password" placeholder="Password" required />
            <i class='bx bxs-lock-alt'></i>
          </div>

          @if ($errors->any())
            <div class="alert alert-danger">
              @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif

          <div class="forgot-link">
            <a href="{{ route('password.request') }}">Lupa Password?</a>
          </div>
          <button type="submit" class="btn">Login</button>
          <p><a href="/">Masuk sebagai Guest</a></p>
      </form>
    </div>

    <!-- Register Form -->
    <div class="form-box register">
      <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf
        <h1>Registration</h1>
        <div class="input-box">
          <input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required />
          <i class='bx bxs-user'></i>
        </div>
        <div class="input-box">
          <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required />
          <i class='bx bxs-envelope'></i>
        </div>
        <div class="input-box">
          <input type="password" name="password" placeholder="Password" required />
          <i class='bx bxs-lock-alt'></i>
        </div>
        <div class="input-box">
          <input type="password" name="password_confirmation" placeholder="Confirm Password" required />
          <i class='bx bxs-lock'></i>
        </div>

        @if ($errors->any())
          <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        @endif

        <button type="submit" class="btn">Register</button>
      </form>
    </div>

    <!-- Toggle Box -->
    <div class="toggle-box">
      <div class="toggle-panel toggle-left">
        <h1>Selamat Datang!</h1>
        <p>Belum punya akun?</p>
        <button class="btn register-btn">Sign Up</button>
      </div>
      <div class="toggle-panel toggle-right">
        <h1>Selamat datang!</h1>
        <p>Sudah punya akun?</p>
        <button class="btn login-btn">Login</button>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/loginpage.js') }}"></script>
</body>
</html>