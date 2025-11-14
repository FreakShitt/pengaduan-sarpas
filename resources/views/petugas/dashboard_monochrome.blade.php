<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Petugas — Pengaduan Sarpas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    <header class="mono-header">
        <div class="mono-container">
            <nav class="mono-nav">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <div class="mono-logo">SARPAS / PETUGAS</div>
                    <button class="mobile-menu-btn" onclick="toggleMenu()">☰</button>
                </div>
                <ul class="mono-nav-links" id="navLinks">
                    <li><a href="{{ route('petugas.dashboard') }}" class="active">Dashboard</a></li>
                    <li><a href="{{ route('petugas.dashboard') }}?status=diajukan">Diajukan</a></li>
                    <li><a href="{{ route('petugas.dashboard') }}?status=diproses">Diproses</a></li>
                    <li class="show-mobile" style="border-top: 1px solid var(--color-gray-200); padding-top: var(--space-3); margin-top: var(--space-3);">
                        <div style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">{{ Auth::user()->nama_pengguna }}</div>
                        <div style="font-size: 0.75rem; color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-3);">Petugas</div>
                        <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" class="mono-btn mono-btn-sm" style="width: 100%;">Logout</button>
                        </form>
                    </li>
                </ul>
                <div class="hide-mobile" style="display: flex; align-items: center; gap: 2rem;">
                    <div style="text-align: right;">
                        <div style="font-size: 0.875rem; font-weight: 600;">{{ Auth::user()->nama_pengguna }}</div>
                        <div style="font-size: 0.75rem; color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.05em;">Petugas</div>
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
                <h1 style="font-size: 4rem; margin-bottom: 1rem;">DASHBOARD PETUGAS</h1>
                <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                    Manajemen & Review Pengaduan Fasilitas
                </p>
            </div>
        </section>

        <!-- Statistics -->
        <section class="mono-section">
            <div class="mono-container">
                <h6 style="margin-bottom: 2rem; color: var(--color-gray-600);">Statistik Seluruh Pengaduan</h6>
                <div class="mono-stats-grid">
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $stats['total'] }}</div>
                        <div class="mono-stat-label">Total</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $stats['diajukan'] }}</div>
                        <div class="mono-stat-label">Diajukan</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $stats['diproses'] }}</div>
                        <div class="mono-stat-label">Diproses</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $stats['selesai'] }}</div>
                        <div class="mono-stat-label">Selesai</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $stats['ditolak'] }}</div>
                        <div class="mono-stat-label">Ditolak</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filters -->
        <section style="background: var(--color-gray-50); padding: 2rem 0; border-bottom: 1px solid var(--color-gray-200);">
            <div class="mono-container">
                <form method="GET" action="{{ route('petugas.dashboard') }}">
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: end;">
                        <div class="mono-form-group" style="margin-bottom: 0;">
                            <label class="mono-label">Pencarian</label>
                            <input type="text" name="search" class="mono-input" placeholder="Cari lokasi, barang, detail..." value="{{ request('search') }}">
                        </div>
                        <div class="mono-form-group" style="margin-bottom: 0;">
                            <label class="mono-label">Status</label>
                            <select name="status" class="mono-select">
                                <option value="">Semua Status</option>
                                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="mono-form-group" style="margin-bottom: 0;">
                            <label class="mono-label">Lokasi</label>
                            <input type="text" name="lokasi" class="mono-input" placeholder="Filter lokasi..." value="{{ request('lokasi') }}">
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <button type="submit" class="mono-btn mono-btn-primary">Filter</button>
                            <a href="{{ route('petugas.dashboard') }}" class="mono-btn">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Reports Table -->
        <section class="mono-section">
            <div class="mono-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                    <h2 style="margin-bottom: 0;">LAPORAN PENGADUAN</h2>
                    <div style="font-size: 0.875rem; color: var(--color-gray-600);">
                        Menampilkan {{ $pengaduans->count() }} dari {{ $pengaduans->total() }} laporan
                    </div>
                </div>

                @if($pengaduans->count() > 0)
                    <div class="table-responsive">
                        <table class="mono-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pelapor</th>
                                    <th>Lokasi</th>
                                    <th>Barang</th>
                                    <th class="hide-mobile">Detail</th>
                                    <th class="hide-mobile">Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengaduans as $pengaduan)
                                <tr>
                                    <td><strong>#{{ $pengaduan->id }}</strong></td>
                                    <td>{{ $pengaduan->user ? $pengaduan->user->nama_pengguna : '-' }}</td>
                                    <td>{{ $pengaduan->lokasi }}</td>
                                    <td>{{ $pengaduan->barang }}</td>
                                    <td class="hide-mobile" style="max-width: 300px;">{{ Str::limit($pengaduan->detail_laporan, 60) }}</td>
                                    <td class="hide-mobile" style="white-space: nowrap;">{{ $pengaduan->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($pengaduan->status == 'diajukan')
                                            <span class="mono-badge">{{ ucfirst($pengaduan->status) }}</span>
                                        @elseif($pengaduan->status == 'diproses')
                                            <span class="mono-badge">{{ ucfirst($pengaduan->status) }}</span>
                                        @elseif($pengaduan->status == 'selesai')
                                            <span class="mono-badge mono-badge-filled">{{ ucfirst($pengaduan->status) }}</span>
                                        @else
                                            <span class="mono-badge mono-badge-outlined">{{ ucfirst($pengaduan->status) }}</span>
                                        @endif
                                </td>
                                <td>
                                    <a href="{{ route('petugas.laporan.show', $pengaduan->id) }}" class="mono-btn mono-btn-sm">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>

                    <!-- Pagination -->
                    <div style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
                        @if($pengaduans->onFirstPage())
                            <span class="mono-btn mono-btn-sm" style="opacity: 0.3; cursor: not-allowed;">← Prev</span>
                        @else
                            <a href="{{ $pengaduans->previousPageUrl() }}" class="mono-btn mono-btn-sm">← Prev</a>
                        @endif

                        <span class="mono-btn mono-btn-sm mono-btn-primary" style="cursor: default;">
                            Page {{ $pengaduans->currentPage() }} / {{ $pengaduans->lastPage() }}
                        </span>

                        @if($pengaduans->hasMorePages())
                            <a href="{{ $pengaduans->nextPageUrl() }}" class="mono-btn mono-btn-sm">Next →</a>
                        @else
                            <span class="mono-btn mono-btn-sm" style="opacity: 0.3; cursor: not-allowed;">Next →</span>
                        @endif
                    </div>
                @else
                    <div style="text-align: center; padding: 4rem 0; border: 1px solid var(--color-gray-200);">
                        <h3 style="color: var(--color-gray-500); font-weight: 400;">Tidak ada laporan ditemukan</h3>
                        <p style="color: var(--color-gray-400);">Coba ubah filter atau pencarian</p>
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
        // Mobile menu toggle
        function toggleMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active');
        }

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
    </script>
</body>
</html>
