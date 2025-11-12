<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Petugas - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #ffffff;
            color: #000000;
            line-height: 1.6;
        }

        /* Header Monochrome */
        .mono-header {
            background: #000000;
            color: #ffffff;
            padding: 1rem 2rem;
            border-bottom: 3px solid #000000;
        }

        .mono-header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mono-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .mono-header nav {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .mono-header nav a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.2s;
        }

        .mono-header nav a:hover {
            opacity: 0.7;
        }

        .logout-btn {
            background: #ffffff;
            color: #000000;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #f0f0f0;
        }

        /* Container */
        .mono-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        /* Hero Section */
        .mono-hero {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #000000;
        }

        .mono-hero h2 {
            font-size: 4rem;
            font-weight: 900;
            letter-spacing: -2px;
            color: #000000;
            margin-bottom: 0.5rem;
        }

        .mono-hero p {
            font-size: 1.125rem;
            color: #666666;
            font-weight: 500;
        }

        /* Form Styles */
        .mono-form {
            background: #ffffff;
            border: 2px solid #000000;
            border-radius: 0;
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
            color: #000000;
        }

        .form-group label .required {
            color: #000000;
            margin-left: 4px;
        }

        .form-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid #000000;
            background: #ffffff;
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.2s;
            color: #000000;
        }

        .form-input:focus {
            outline: none;
            border-color: #000000;
            background: #f9f9f9;
        }

        .form-input::placeholder {
            color: #999999;
        }

        .error-message {
            color: #000000;
            font-size: 0.875rem;
            font-weight: 600;
            margin-top: 0.5rem;
            display: block;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 2px solid #000000;
        }

        .btn-primary {
            flex: 1;
            background: #000000;
            color: #ffffff;
            padding: 1rem 2rem;
            border: 2px solid #000000;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            background: #ffffff;
            color: #000000;
        }

        .btn-secondary {
            flex: 1;
            background: #ffffff;
            color: #000000;
            padding: 1rem 2rem;
            border: 2px solid #000000;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #000000;
            color: #ffffff;
        }

        /* Alert */
        .alert {
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border: 2px solid #000000;
            background: #f9f9f9;
        }

        .alert-error {
            background: #fff5f5;
        }

        .alert strong {
            font-weight: 700;
            display: block;
            margin-bottom: 0.5rem;
        }

        .alert ul {
            margin-left: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Header Monochrome -->
    <header class="mono-header">
        <div class="mono-header-content">
            <h1>ADMIN PANEL</h1>
            <nav>
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.petugas.index') }}">Petugas</a>
                <a href="{{ route('admin.users.index') }}">Users</a>
                <a href="{{ route('admin.lokasi.index') }}">Lokasi</a>
                <a href="{{ route('admin.barang.index') }}">Barang</a>
                <a href="{{ route('admin.laporan') }}">Laporan</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <div class="mono-container">
        <!-- Hero Section -->
        <div class="mono-hero">
            <h2>TAMBAH PETUGAS</h2>
            <p>Tambahkan petugas baru ke sistem</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Terdapat kesalahan pada input:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.petugas.store') }}" method="POST" class="mono-form">
            @csrf
            
            <div class="form-group">
                <label for="nama_pengguna">
                    Nama Lengkap
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="nama_pengguna" 
                    name="nama_pengguna" 
                    class="form-input" 
                    value="{{ old('nama_pengguna') }}" 
                    placeholder="Masukkan nama lengkap petugas"
                    required
                >
                @error('nama_pengguna')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="username">
                    Username
                    <span class="required">*</span>
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="form-input" 
                    value="{{ old('username') }}" 
                    placeholder="Username untuk login"
                    required
                >
                @error('username')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">
                    Password
                    <span class="required">*</span>
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="Minimal 6 karakter"
                    required
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Konfirmasi Password
                    <span class="required">*</span>
                </label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-input" 
                    placeholder="Ketik ulang password"
                    required
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Simpan</button>
                <a href="{{ route('admin.petugas.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
