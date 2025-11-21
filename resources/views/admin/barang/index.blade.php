<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Barang — Pengaduan Sarpas</title>
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
                    <li><a href="{{ route('admin.petugas.index') }}">Petugas</a></li>
                    <li><a href="{{ route('admin.lokasi.index') }}">Lokasi</a></li>
                    <li><a href="{{ route('admin.barang.index') }}" class="active">Barang</a></li>
                    <li><a href="{{ route('admin.item-requests.index') }}">Item Requests</a></li>
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
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <h1 style="font-size: 4rem; margin-bottom: 1rem;">KELOLA BARANG</h1>
                        <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                            Manajemen Master Data Barang Sarpras
                        </p>
                    </div>
                    <a href="{{ route('admin.barang.create') }}" class="mono-btn mono-btn-lg">
                        <svg style="width: 20px; height: 20px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        TAMBAH BARANG
                    </a>
                </div>
            </div>
        </section>

        @if(session('success'))
        <section class="mono-section" style="padding: 2rem 0;">
            <div class="mono-container">
                <div style="background: var(--color-green-50); border-left: 4px solid var(--color-green-600); padding: 1rem 1.5rem; border-radius: 8px;">
                    <p style="color: var(--color-green-600); font-weight: 600; margin: 0;">{{ session('success') }}</p>
                </div>
            </div>
        </section>
        @endif

        @if(session('error'))
        <section class="mono-section" style="padding: 2rem 0;">
            <div class="mono-container">
                <div style="background: var(--color-red-50); border-left: 4px solid var(--color-red-600); padding: 1rem 1.5rem; border-radius: 8px;">
                    <p style="color: var(--color-red-600); font-weight: 600; margin: 0;">{{ session('error') }}</p>
                </div>
            </div>
        </section>
        @endif

        <!-- Stats -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                <div class="mono-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $barang->count() }}</div>
                        <div class="mono-stat-label">Total Barang</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $barang->where('aktif', true)->count() }}</div>
                        <div class="mono-stat-label">Aktif</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $barang->where('aktif', false)->count() }}</div>
                        <div class="mono-stat-label">Tidak Aktif</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter Lokasi -->
        <section class="mono-section">
            <div class="mono-container">
                <form method="GET" action="{{ route('admin.barang.index') }}" style="margin-bottom: 3rem;">
                    <div style="display: flex; gap: 1rem; align-items: end;">
                        <div style="flex: 1; max-width: 350px;">
                            <label for="lokasi" style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-gray-700); margin-bottom: 0.5rem;">
                                Filter by Lokasi
                            </label>
                            <select name="lokasi" id="lokasi" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: 8px; font-size: 0.9375rem; background: white;">
                                <option value="">Semua Lokasi</option>
                                <option value="Ruang Kelas" {{ request('lokasi') == 'Ruang Kelas' ? 'selected' : '' }}>Ruang Kelas (Semua)</option>
                                @foreach($lokasi as $loc)
                                    @if(!stripos($loc->nama_lokasi, 'kelas') && !stripos($loc->nama_lokasi, 'ruang kelas'))
                                        <option value="{{ $loc->nama_lokasi }}" {{ request('lokasi') == $loc->nama_lokasi ? 'selected' : '' }}>
                                            {{ $loc->nama_lokasi }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="mono-btn">Filter</button>
                        <a href="{{ route('admin.barang.index') }}" class="mono-btn mono-btn-ghost">Reset</a>
                    </div>
                </form>

                @if(request('lokasi'))
                <div style="background: var(--color-blue-50); border-left: 4px solid var(--color-blue-600); padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                    <p style="color: var(--color-blue-600); font-weight: 600; margin: 0;">
                        Menampilkan barang untuk: <strong>{{ request('lokasi') }}</strong> ({{ $barang->count() }} barang)
                    </p>
                </div>
                @endif
                @if($barang->count() > 0)
                    <table class="mono-table">
                        <thead>
                            <tr>
                                <th style="width: 60px; text-align: center;">NO</th>
                                <th>NAMA BARANG</th>
                                <th>LOKASI</th>
                                <th>DESKRIPSI</th>
                                <th>STATUS</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang as $index => $b)
                            <tr>
                                <td style="text-align: center; font-weight: 600;">{{ $barang->firstItem() + $index }}</td>
                                <td><strong>{{ $b->nama_barang }}</strong></td>
                                <td>
                                    <span class="mono-badge">
                                        {{ $b->nama_lokasi }}
                                    </span>
                                </td>
                                <td style="color: var(--color-gray-600); max-width: 300px;">{{ $b->deskripsi ?? '-' }}</td>
                                <td>
                                    @if($b->aktif)
                                        <span class="mono-badge" style="background: var(--color-green-50); color: var(--color-green-600);">✓ Aktif</span>
                                    @else
                                        <span class="mono-badge" style="background: var(--color-red-50); color: var(--color-red-600);">✕ Tidak Aktif</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: inline-flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.barang.edit', $b->id) }}" class="mono-btn mono-btn-sm" style="background: var(--color-blue-50); color: var(--color-blue-600);">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.barang.destroy', $b->id) }}" method="POST" style="display: inline;"
                                              onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="mono-btn mono-btn-sm" style="background: var(--color-red-50); color: var(--color-red-600);">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div style="margin-top: 2rem;">
                        {{ $barang->links() }}
                    </div>
                @else
                    <div style="text-align: center; padding: 6rem 0; border: 2px solid var(--color-gray-200);">
                        <div style="font-size: 6rem; margin-bottom: 1.5rem; opacity: 0.2;">📦</div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Belum ada barang terdaftar</h3>
                        <p style="color: var(--color-gray-600); margin-bottom: 2rem;">Mulai dengan menambahkan barang pertama Anda</p>
                        <a href="{{ route('admin.barang.create') }}" class="mono-btn">TAMBAH BARANG</a>
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
        // Smooth scroll
        document.documentElement.style.scrollBehavior = 'smooth';

        // Fade in animations
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

        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[style*="color-green-50"], [style*="color-red-50"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
