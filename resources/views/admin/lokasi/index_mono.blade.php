<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokasi Management — Admin</title>
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
                <h1 style="font-size: 4rem; margin-bottom: 1rem;">LOKASI</h1>
                <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                    Manajemen master data lokasi
                </p>
            </div>
        </section>

        <!-- Success Alert -->
        @if (session('success'))
        <section style="background: var(--color-gray-50); padding: 1.5rem 0; border-bottom: 1px solid var(--color-gray-200);">
            <div class="mono-container">
                <div class="mono-alert mono-alert-success">
                    {{ session('success') }}
                </div>
            </div>
        </section>
        @endif

        <!-- Data Section -->
        <section class="mono-section">
            <div class="mono-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                    <h6 style="color: var(--color-gray-600); margin-bottom: 0;">Total: {{ $lokasi->count() }} Lokasi</h6>
                    <a href="{{ route('admin.lokasi.create') }}" class="mono-btn mono-btn-primary">+ Tambah Lokasi</a>
                </div>

                @if($lokasi->count() > 0)
                    <table class="mono-table">
                        <thead>
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th>Nama Lokasi</th>
                                <th>Deskripsi</th>
                                <th style="width: 120px; text-align: center;">Barang</th>
                                <th style="width: 100px; text-align: center;">Status</th>
                                <th style="width: 200px; text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lokasi as $lok)
                            <tr>
                                <td><strong>#{{ $lok->id }}</strong></td>
                                <td style="font-weight: 600;">{{ $lok->nama_lokasi }}</td>
                                <td style="color: var(--color-gray-700);">
                                    {{ $lok->deskripsi ? Str::limit($lok->deskripsi, 60) : '—' }}
                                </td>
                                <td style="text-align: center;">
                                    <span class="mono-badge">{{ $lok->barang_count ?? 0 }}</span>
                                </td>
                                <td style="text-align: center;">
                                    @if($lok->aktif)
                                        <span class="mono-badge mono-badge-filled">Aktif</span>
                                    @else
                                        <span class="mono-badge mono-badge-outlined">Nonaktif</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: flex-end;">
                                        <a href="{{ route('admin.lokasi.edit', $lok->id) }}" class="mono-btn mono-btn-sm">Edit</a>
                                        <form action="{{ route('admin.lokasi.destroy', $lok->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?');" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="mono-btn mono-btn-sm" style="border-color: var(--color-gray-400); color: var(--color-gray-600);">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; padding: 4rem 0; border: 1px solid var(--color-gray-200);">
                        <h3 style="color: var(--color-gray-500); font-weight: 400;">Belum ada lokasi</h3>
                        <p style="color: var(--color-gray-400); margin-bottom: 2rem;">Tambahkan lokasi pertama</p>
                        <a href="{{ route('admin.lokasi.create') }}" class="mono-btn mono-btn-primary">+ Tambah Lokasi</a>
                    </div>
                @endif
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

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('mono-fade-in');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.mono-section').forEach(section => {
            observer.observe(section);
        });
    </script>
</body>
</html>
