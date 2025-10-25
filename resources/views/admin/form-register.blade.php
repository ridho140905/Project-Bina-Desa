<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - Admin Dashboard</title>

  <!-- Load CSS dari folder admin -->
  <link rel="stylesheet" href="/admin/css/main.css">

  <!-- Material Design Icons -->
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      background: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .register-container {
      width: 100%;
      max-width: 450px;
    }

    .register-card {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      border: 1px solid #e5e7eb;
      overflow: hidden;
    }

    .card-header {
      background: #1f2937;
      color: white;
      padding: 30px;
      text-align: center;
      border-bottom: 1px solid #374151;
    }

    .card-header .icon {
      font-size: 2rem;
      margin-bottom: 10px;
      display: block;
      color: #9ca3af;
    }

    .card-header-title {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 5px;
      color: white;
    }

    .card-header-subtitle {
      font-size: 0.9rem;
      color: #9ca3af;
    }

    .card-content {
      padding: 40px;
    }

    .notification {
      margin-bottom: 20px;
      border-radius: 6px;
      padding: 12px 16px;
      border-left: 4px solid;
      font-size: 0.9rem;
    }

    .notification.is-success {
      background: #f0f9ff;
      border-left-color: #0369a1;
      color: #075985;
    }

    .notification.is-danger {
      background: #fef2f2;
      border-left-color: #dc2626;
      color: #991b1b;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-label {
      display: block;
      font-weight: 500;
      color: #374151;
      margin-bottom: 8px;
      font-size: 0.9rem;
    }

    .input-group {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #6b7280;
      z-index: 2;
    }

    .form-input {
      width: 100%;
      padding: 12px 12px 12px 40px;
      border: 1px solid #d1d5db;
      border-radius: 6px;
      font-size: 0.95rem;
      transition: all 0.2s ease;
      background: white;
      color: #374151;
    }

    .form-input:focus {
      outline: none;
      border-color: #374151;
      box-shadow: 0 0 0 3px rgba(55, 65, 81, 0.1);
    }

    .btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 6px;
      font-size: 0.95rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .btn-primary {
      background: #374151;
      color: white;
    }

    .btn-primary:hover {
      background: #1f2937;
      transform: translateY(-1px);
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-secondary {
      background: white;
      color: #374151;
      border: 1px solid #d1d5db;
      margin-top: 10px;
    }

    .btn-secondary:hover {
      background: #f9fafb;
      border-color: #9ca3af;
    }

    .login-link {
      text-align: center;
      margin-top: 25px;
      padding-top: 20px;
      border-top: 1px solid #e5e7eb;
    }

    .login-link p {
      color: #6b7280;
      font-size: 0.9rem;
    }

    .login-link a {
      color: #374151;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s ease;
    }

    .login-link a:hover {
      color: #1f2937;
      text-decoration: underline;
    }

    .error-message {
      color: #dc2626;
      font-size: 0.8rem;
      margin-top: 5px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .register-card {
      animation: fadeIn 0.5s ease;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <div class="register-card">
      <div class="card-header">
        <i class="mdi mdi-account-plus icon"></i>
        <h1 class="card-header-title">Bina Desa</h1>
        <p class="card-header-subtitle">Create your account</p>
      </div>

      <div class="card-content">
        <!-- Flash Messages -->
        @if(session('success'))
        <div class="notification is-success">
          <i class="mdi mdi-check-circle"></i>
          {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="notification is-danger">
          <i class="mdi mdi-alert-circle"></i>
          {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('auth.register') }}">
          @csrf

          <div class="form-group">
            <label class="form-label">Full Name</label>
            <div class="input-group">
              <i class="mdi mdi-account input-icon"></i>
              <input class="form-input" type="text" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required>
            </div>
            @error('name')
              <div class="error-message">
                <i class="mdi mdi-alert"></i> {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Email Address</label>
            <div class="input-group">
              <i class="mdi mdi-email input-icon"></i>
              <input class="form-input" type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
            </div>
            @error('email')
              <div class="error-message">
                <i class="mdi mdi-alert"></i> {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Password</label>
            <div class="input-group">
              <i class="mdi mdi-lock input-icon"></i>
              <input class="form-input" type="password" name="password" placeholder="Create a password" required>
            </div>
            @error('password')
              <div class="error-message">
                <i class="mdi mdi-alert"></i> {{ $message }}
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
              <i class="mdi mdi-lock-check input-icon"></i>
              <input class="form-input" type="password" name="password_confirmation" placeholder="Confirm your password" required>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="mdi mdi-account-plus"></i>
            Create Account
          </button>

          <a href="{{ route('auth.index') }}" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i>
            Back to Login
          </a>

          <div class="login-link">
            <p>Already have an account? <a href="{{ route('auth.index') }}">Sign in</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="/admin/js/main.min.js"></script>
</body>
</html>
