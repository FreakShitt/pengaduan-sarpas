<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    <header class="mono-header">
        <div class="mono-container">
            <nav class="mono-nav">
                <div class="mono-logo">SARPAS / ADMIN</div>
                <ul class="mono-nav-links">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.laporan') }}">Laporan</a></li>
                    <li><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li><a href="{{ route('admin.lokasi.index') }}" class="active">Lokasi</a></li>
                    <li><a href="{{ route('admin.barang.index') }}">Barang</a></li>
                </ul>
                <div style="display: flex; align-items: center; gap: 2rem;">
                    <div style="text-align: right;">
                        <div style="font-size: 0.875rem; font-weight: 600;">{{ Auth::user()->nama_pengguna }}</div>
                        <div style="font-size: 0.75rem; color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.05em;">Administrator</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="mono-btn mono-btn-sm">Logout</button>
                    </form>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="mono-section" style="padding: 6rem 0 4rem; border-bottom: 2px solid black;">
            <div class="mono-container">
                <h1 style="font-size: 4rem; margin-bottom: 1rem;">TAMBAH LOKASI</h1>
                <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                    Tambah lokasi baru ke dalam sistem
                </p>
            </div>
        </section>

        <!-- Form Section -->
        <section class="mono-section">
            <div class="mono-container" style="max-width: 700px;">
                
                @if ($errors->any())
                <div class="mono-alert mono-alert-error" style="margin-bottom: 2rem;">
                    <strong style="display: block; margin-bottom: 0.5rem;">Terdapat kesalahan:</strong>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.lokasi.store') }}" method="POST">
                    @csrf

                    <div class="mono-form-group">
                        <label class="mono-label" for="nama_lokasi">Nama Lokasi <span style="color: var(--color-gray-400);">*</span></label>
                        <input 
                            type="text" 
                            id="nama_lokasi" 
                            name="nama_lokasi" 
                            class="mono-input" 
                            value="{{ old('nama_lokasi') }}" 
                            required
                            placeholder="Contoh: Ruang Kelas 10A, Laboratorium IPA, dsb.">
                    </div>

                    <div class="mono-form-group">
                        <label class="mono-label" for="deskripsi">Deskripsi (Opsional)</label>
                        <textarea 
                            id="deskripsi" 
                            name="deskripsi" 
                            class="mono-textarea"
                            placeholder="Deskripsi detail lokasi...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="mono-form-group">
                        <label class="mono-label" for="aktif">Status</label>
                        <select id="aktif" name="aktif" class="mono-select" required>
                            <option value="1" {{ old('aktif', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('aktif') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="mono-divider"></div>

                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <a href="{{ route('admin.lokasi.index') }}" class="mono-btn mono-btn-ghost">
                            Batal
                        </a>
                        <button type="submit" class="mono-btn mono-btn-primary">
                            Simpan Lokasi
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer style="border-top: 1px solid var(--color-gray-200); padding: 3rem 0; margin-top: 4rem;">
        <div class="mono-container">
            <div style="text-align: center; color: var(--color-gray-500); font-size: 0.875rem;">
                <p>&copy; {{ date('Y') }} SARPAS — Sistem Pengaduan Sarana Prasarana</p>
            </div>
        </div>
    </footer>

    <script>
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>
