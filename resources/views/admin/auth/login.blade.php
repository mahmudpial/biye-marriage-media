<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Biye Marriage Media Admin Portal</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('site-logo/marriage-logo.jpeg') }}">
    <link rel="shortcut icon" type="image/jpeg" href="{{ asset('site-logo/marriage-logo.jpeg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,500&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-burgundy: #2c0712;
            --deep-maroon: #1a040b;
            --accent-gold: #d4af37;
            --gold-light: #f5e7a9;
            --gold-glow: rgba(212, 175, 55, 0.35);
            --card-glass: rgba(30, 6, 15, 0.75);
            --text-light: #fdfaf6;
            --text-muted: #d0c2c7;
            --input-bg: rgba(255, 255, 255, 0.08);
            --input-border: rgba(212, 175, 55, 0.3);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: radial-gradient(circle at 50% 15%, #460c1d 0%, #1e050d 45%, #0d0206 100%);
            font-family: 'Poppins', sans-serif;
            color: var(--text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glow & Decorative Circles */
        .ambient-glow-1 {
            position: absolute;
            top: -120px;
            left: -120px;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .ambient-glow-2 {
            position: absolute;
            bottom: -150px;
            right: -100px;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(167, 29, 63, 0.25) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
            background: var(--card-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--input-border);
            border-radius: 24px;
            padding: 2.75rem 2.25rem;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6), 0 0 30px var(--gold-glow);
            position: relative;
            z-index: 10;
            transition: transform 0.3s ease;
        }

        .logo-wrapper {
            position: relative;
            display: inline-block;
            margin-bottom: 1.25rem;
        }

        .brand-logo {
            width: 82px;
            height: 82px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid var(--accent-gold);
            box-shadow: 0 0 20px var(--gold-glow);
        }

        .logo-badge {
            position: absolute;
            bottom: -4px;
            right: -6px;
            background: var(--accent-gold);
            color: #1a040b;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 12px;
            border: 2px solid var(--deep-maroon);
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gold-light);
            margin-bottom: 0.25rem;
            letter-spacing: 0.5px;
        }

        .brand-subtitle {
            font-size: 0.88rem;
            color: #e2d5da;
            margin-bottom: 1.75rem;
        }

        .form-label {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--gold-light);
            margin-bottom: 0.45rem;
        }

        .input-group {
            border: 1px solid var(--input-border);
            border-radius: 12px;
            background: var(--input-bg);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .input-group:focus-within {
            border-color: var(--accent-gold);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.3);
            background: rgba(255, 255, 255, 0.12);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--accent-gold);
            font-size: 1.1rem;
            padding-left: 1rem;
        }

        .form-control {
            background: transparent !important;
            border: none !important;
            color: #ffffff !important;
            font-size: 0.95rem;
            padding: 0.75rem 1rem 0.75rem 0.5rem;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus {
            box-shadow: none !important;
        }

        .toggle-password {
            background: transparent;
            border: none;
            color: #cbd5e1;
            cursor: pointer;
            padding-right: 1rem;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: var(--accent-gold);
        }

        .btn-login {
            background: linear-gradient(135deg, #d4af37 0%, #aa820a 100%);
            color: #170308;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.5px;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            width: 100%;
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.35);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #f2cd54 0%, #c4960d 100%);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(212, 175, 55, 0.5);
            color: #0d0206;
        }

        .demo-box {
            background: rgba(212, 175, 55, 0.12);
            border: 1px dashed rgba(212, 175, 55, 0.45);
            border-radius: 12px;
            padding: 0.95rem;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #f1e7ec;
        }

        .demo-box code {
            background: rgba(0, 0, 0, 0.45);
            color: var(--gold-light);
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
        }

        .demo-box strong {
            color: #ffffff;
        }

        .btn-fill-demo {
            background: rgba(212, 175, 55, 0.25);
            color: var(--gold-light);
            border: 1px solid var(--accent-gold);
            font-size: 0.76rem;
            font-weight: 600;
            padding: 0.3rem 0.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-fill-demo:hover {
            background: var(--accent-gold);
            color: #1a040b;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            color: #e2d5da;
            text-decoration: none;
            font-size: 0.88rem;
            margin-top: 1.5rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: var(--accent-gold);
        }

        .custom-check .form-check-input {
            background-color: var(--input-bg);
            border-color: var(--input-border);
            cursor: pointer;
        }

        .custom-check .form-check-input:checked {
            background-color: var(--accent-gold);
            border-color: var(--accent-gold);
        }

        .custom-check .form-check-label {
            font-size: 0.88rem;
            color: #e2d5da;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="ambient-glow-1"></div>
    <div class="ambient-glow-2"></div>

    <div class="login-card text-center">
        <!-- Brand Logo Header -->
        <div class="logo-wrapper">
            <img src="{{ asset('site-logo/marriage-logo.jpeg') }}" alt="Biye Media Logo" class="brand-logo">
            <span class="logo-badge"><i class="bi bi-shield-lock-fill"></i> ADMIN</span>
        </div>

        <h1 class="brand-title">Admin Console</h1>
        <p class="brand-subtitle">Biye Marriage Media &bull; Secure Management System</p>

        <!-- Flash Notifications -->
        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show border-0 py-2 px-3 text-start mb-3" style="background: rgba(13, 202, 240, 0.15); color: #7feaff; font-size: 0.85rem;" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 py-2 px-3 text-start mb-3" style="background: rgba(220, 53, 69, 0.2); color: #ff8e9b; font-size: 0.85rem;" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.login.submit') }}" class="text-start">
            @csrf

            <!-- Email Field -->
            <div class="mb-3">
                <label for="adminEmail" class="form-label">
                    <i class="bi bi-envelope-fill me-1 text-gold"></i> Admin Email
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="adminEmail" 
                        name="email" 
                        value="{{ old('email', 'admin@biyemedia.com') }}" 
                        placeholder="admin@biyemedia.com" 
                        required 
                        autocomplete="email"
                        autofocus
                    >
                </div>
            </div>

            <!-- Password Field -->
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="adminPassword" class="form-label mb-0">
                        <i class="bi bi-lock-fill me-1 text-gold"></i> Password
                    </label>
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                    <input 
                        type="password" 
                        class="form-control" 
                        id="adminPassword" 
                        name="password" 
                        placeholder="••••••••" 
                        required 
                        autocomplete="current-password"
                    >
                    <button type="button" class="toggle-password" id="togglePasswordBtn" title="Toggle password visibility">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check custom-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="rememberMe" checked>
                    <label class="form-check-label" for="rememberMe">
                        Remember Me
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-login" id="loginSubmitBtn">
                <span>Sign In to Admin Console</span>
                <i class="bi bi-arrow-right-circle-fill"></i>
            </button>
        </form>

        <!-- Quick Demo Credentials helper for easy login -->
        <div class="demo-box text-start">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span><i class="bi bi-key-fill text-gold me-1"></i> <strong>Default Admin Credentials:</strong></span>
                <button type="button" class="btn-fill-demo" id="autoFillBtn">
                    <i class="bi bi-magic me-1"></i> Auto-Fill
                </button>
            </div>
            <div>Email: <code>admin@biyemedia.com</code></div>
            <div>Password: <code>admin123456</code></div>
        </div>

        <!-- Back to Main Site -->
        <div class="mt-3">
            <a href="{{ route('home') }}" class="back-link">
                <i class="bi bi-house-door-fill"></i> Return to Main Website
            </a>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Password Visibility Toggle
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passInput = document.getElementById('adminPassword');
        const toggleIcon = document.getElementById('toggleIcon');

        toggleBtn.addEventListener('click', function () {
            const isPassword = passInput.type === 'password';
            passInput.type = isPassword ? 'text' : 'password';
            toggleIcon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
        });

        // Quick Auto-Fill Demo Button
        document.getElementById('autoFillBtn').addEventListener('click', function () {
            document.getElementById('adminEmail').value = 'admin@biyemedia.com';
            document.getElementById('adminPassword').value = 'admin123456';
            passInput.focus();
        });
    </script>
</body>
</html>
