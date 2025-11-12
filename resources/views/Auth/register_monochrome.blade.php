<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Pengaduan Sarpas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background: var(--color-white); padding: 2rem 0;">
    
    <div style="width: 100%; max-width: 520px; padding: 2rem;">
        <!-- Logo -->
        <div style="text-align: center; margin-bottom: 4rem;">
            <div class="mono-logo" style="font-size: 2.5rem; margin-bottom: 1rem;">SARPAS</div>
            <p style="color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.875rem;">
                Sistem Pengaduan Sarana Prasarana
            </p>
        </div>

        <!-- Register Form -->
        <div style="border: 2px solid var(--color-black); padding: 3rem;">
            <h2 style="margin-bottom: 2rem; text-align: center;">REGISTER</h2>

            @if ($errors->any())
                <div class="mono-alert mono-alert-error">
                    <ul style="list-style: none; margin: 0; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mono-form-group">
                    <label class="mono-label" for="nama_pengguna">Nama Lengkap</label>
                    <input 
                        type="text" 
                        id="nama_pengguna" 
                        name="nama_pengguna" 
                        class="mono-input" 
                        value="{{ old('nama_pengguna') }}" 
                        required 
                        autofocus
                        placeholder="Nama lengkap Anda">
                </div>

                <div class="mono-form-group">
                    <label class="mono-label" for="username">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="mono-input" 
                        value="{{ old('username') }}" 
                        required
                        placeholder="Username unik">
                </div>

                <div class="mono-form-group">
                    <label class="mono-label" for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="mono-input" 
                        required
                        placeholder="Minimal 6 karakter">
                </div>

                <div class="mono-form-group">
                    <label class="mono-label" for="password_confirmation">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="mono-input" 
                        required
                        placeholder="Ulangi password">
                </div>

                <div class="mono-form-group">
                    <label class="mono-label" for="role">Role</label>
                    <select id="role" name="role" class="mono-select" required>
                        <option value="">Pilih Role</option>
                        <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                        <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    </select>
                </div>

                <button type="submit" class="mono-btn mono-btn-primary" style="width: 100%; margin-top: 1rem;">
                    Register
                </button>
            </form>

            <div class="mono-divider"></div>

            <p style="text-align: center; color: var(--color-gray-600); font-size: 0.875rem;">
                Sudah punya akun? 
                <a href="{{ route('login') }}" style="text-decoration: underline; color: var(--color-black); font-weight: 600;">
                    Login
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
