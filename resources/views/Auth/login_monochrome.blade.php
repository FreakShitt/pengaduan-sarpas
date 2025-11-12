<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Pengaduan Sarpas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background: var(--color-white);">
    
    <div style="width: 100%; max-width: 480px; padding: 2rem;">
        <!-- Logo -->
        <div style="text-align: center; margin-bottom: 4rem;">
            <div class="mono-logo" style="font-size: 2.5rem; margin-bottom: 1rem;">SARPAS</div>
            <p style="color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.875rem;">
                Sistem Pengaduan Sarana Prasarana
            </p>
        </div>

        <!-- Login Form -->
        <div style="border: 2px solid var(--color-black); padding: 3rem;">
            <h2 style="margin-bottom: 2rem; text-align: center;">LOGIN</h2>

            @if (session('success'))
                <div class="mono-alert mono-alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mono-alert mono-alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mono-alert mono-alert-error">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mono-form-group">
                    <label class="mono-label" for="username">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="mono-input" 
                        value="{{ old('username') }}" 
                        required 
                        autofocus
                        placeholder="Masukkan username">
                </div>

                <div class="mono-form-group">
                    <label class="mono-label" for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="mono-input" 
                        required
                        placeholder="Masukkan password">
                </div>

                <button type="submit" class="mono-btn mono-btn-primary" style="width: 100%; margin-top: 1rem;">
                    Login
                </button>
            </form>

            <div class="mono-divider"></div>

            <p style="text-align: center; color: var(--color-gray-600); font-size: 0.875rem;">
                Belum punya akun? 
                <a href="{{ route('register') }}" style="text-decoration: underline; color: var(--color-black); font-weight: 600;">
                    Register
                </a>
            </p>
        </div>

        <!-- Footer Info -->
        <div style="text-align: center; margin-top: 3rem; color: var(--color-gray-500); font-size: 0.75rem;">
            <p>&copy; {{ date('Y') }} SARPAS</p>
        </div>
    </div>

</body>
</html>
