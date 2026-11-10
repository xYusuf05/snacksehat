<!DOCTYPE html>
<html lang="id" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – SnackCheck</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
            display: flex; align-items: center; justify-content: center;
            padding: 1rem;
        }

        /* Pattern overlay */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: radial-gradient(circle at 20% 50%, rgba(34,211,238,.08) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(99,102,241,.08) 0%, transparent 40%);
            pointer-events: none;
        }

        .login-card {
            width: 100%; max-width: 420px;
            background: rgba(255,255,255,.97);
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 25px 60px rgba(0,0,0,.35);
            position: relative;
        }

        .brand-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #22d3ee, #6366f1);
            border-radius: 1rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; color: #fff;
            margin: 0 auto 1rem;
        }

        .form-control {
            padding: .65rem 1rem;
            border-radius: .75rem;
            border-color: #e2e8f0;
            font-size: .9rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-control:focus {
            border-color: #22d3ee;
            box-shadow: 0 0 0 3px rgba(34,211,238,.15);
        }

        .btn-login {
            background: linear-gradient(135deg, #22d3ee, #6366f1);
            border: none; color: #fff;
            padding: .7rem; border-radius: .75rem;
            font-weight: 600; font-size: .95rem;
            transition: opacity .2s, transform .1s;
        }
        .btn-login:hover  { opacity: .9; color: #fff; }
        .btn-login:active { transform: scale(.98); }

        .input-group-text {
            border-radius: .75rem 0 0 .75rem !important;
            background: #f8fafc; border-color: #e2e8f0; color: #94a3b8;
        }
        .input-group .form-control { border-radius: 0 .75rem .75rem 0 !important; }

        .demo-box {
            background: #f8fafc; border-radius: .75rem;
            padding: .75rem 1rem; font-size: .78rem; color: #475569;
        }
        .demo-box code { color: #6366f1; font-weight: 600; }
    </style>
</head>
<body>
    <div class="login-card">

        {{-- Brand --}}
        <div class="text-center mb-4">
            <div class="brand-icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <h4 class="fw-800 mb-1" style="color:#0f172a;">SnackCheck</h4>
            <p class="text-secondary mb-0" style="font-size:.85rem;">
                Klasifikasi Snack Sehat dengan CART
            </p>
        </div>

        {{-- Session errors --}}
        @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-3 py-2 mb-3" style="font-size:.85rem;">
            <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
        </div>
        @endif

        @if (session('status'))
        <div class="alert alert-success border-0 rounded-3 py-2 mb-3" style="font-size:.85rem;">
            {{ session('status') }}
        </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-500" style="font-size:.875rem;">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" placeholder="nama@email.com" autofocus required>
                </div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <label class="form-label fw-500" style="font-size:.875rem;">Password</label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size:.8rem; color:#6366f1;">
                        Lupa password?
                    </a>
                    @endif
                </div>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" id="pwInput"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••" required>
                    <button type="button" class="btn btn-outline-secondary border-start-0"
                            style="border-radius:0 .75rem .75rem 0; border-color:#e2e8f0;"
                            onclick="togglePw()">
                        <i class="bi bi-eye" id="pwIcon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4 d-flex align-items-center">
                <input type="checkbox" name="remember" id="remember" class="form-check-input me-2">
                <label for="remember" class="form-check-label" style="font-size:.875rem;">Ingat saya</label>
            </div>

            <button type="submit" class="btn btn-login w-100">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
            </button>
        </form>

        @if (Route::has('register'))
        <p class="text-center mt-3 mb-3" style="font-size:.85rem; color:#94a3b8;">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-decoration-none fw-600" style="color:#6366f1;">Daftar</a>
        </p>
        @endif

        {{-- Demo credentials --}}
        <div class="demo-box">
            <div class="fw-600 mb-1">Akun Demo:</div>
            <div>Admin &nbsp;→ <code>admin@snackcheck.com</code> / <code>password</code></div>
            <div>User &nbsp;&nbsp;→ <code>user@snackcheck.com</code> / <code>password</code></div>
        </div>

    </div>

    <script>
        function togglePw() {
            const input = document.getElementById('pwInput');
            const icon  = document.getElementById('pwIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>
</body>
</html>