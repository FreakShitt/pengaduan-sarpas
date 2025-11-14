<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Pengaduan Sarpas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    <header class="mono-header">
        <div class="mono-container">
            <nav class="mono-nav">
                <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                    <div class="mono-logo">SARPAS</div>
                    <button class="mobile-menu-btn" onclick="toggleMenu()">☰</button>
                </div>
                <ul class="mono-nav-links" id="navLinks">
                    <li><a href="{{ route('dashboard') }}" class="active">Dashboard</a></li>
                    <li><a href="{{ route('pengaduan.index') }}">Pengaduan</a></li>
                    <li><a href="{{ route('pengaduan.create') }}">Buat Laporan</a></li>
                    <li class="show-mobile" style="border-top: 1px solid var(--color-gray-200); padding-top: var(--space-3); margin-top: var(--space-3);">
                        <div style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">{{ Auth::user()->nama_pengguna }}</div>
                        <div style="font-size: 0.75rem; color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-3);">{{ Auth::user()->role }}</div>
                        <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" class="mono-btn mono-btn-sm" style="width: 100%;">Logout</button>
                        </form>
                    </li>
                </ul>
                <div class="hide-mobile" style="display: flex; align-items: center; gap: 2rem;">
                    <div style="text-align: right;">
                        <div style="font-size: 0.875rem; font-weight: 600;">{{ Auth::user()->nama_pengguna }}</div>
                        <div style="font-size: 0.75rem; color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.05em;">{{ Auth::user()->role }}</div>
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
                <h1 style="font-size: 4rem; margin-bottom: 1rem;">DASHBOARD</h1>
                <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                    Sistem Pengaduan Sarana & Prasarana
                </p>
            </div>
        </section>

        <!-- Statistics -->
        <section class="mono-section">
            <div class="mono-container">
                <h6 style="margin-bottom: 2rem; color: var(--color-gray-600);">Statistik Pengaduan</h6>
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

        <!-- Recent Reports -->
        <section class="mono-section">
            <div class="mono-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h2 style="margin-bottom: 0;">RECENT REPORTS</h2>
                    <a href="{{ route('pengaduan.index') }}" class="mono-btn mono-btn-ghost">View All →</a>
                </div>

                <!-- Filter by Status -->
                <form method="GET" action="{{ route('dashboard') }}" style="margin-bottom: 2rem;">
                    <div style="display: flex; gap: 1rem; align-items: end;">
                        <div class="mono-form-group" style="margin-bottom: 0; flex: 1; max-width: 300px;">
                            <label class="mono-label" for="status">Filter by Status</label>
                            <select id="status" name="status" class="mono-select">
                                <option value="">Semua Status</option>
                                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <button type="submit" class="mono-btn mono-btn-primary">Filter</button>
                        @if(request('status'))
                            <a href="{{ route('dashboard') }}" class="mono-btn">Reset</a>
                        @endif
                    </div>
                </form>

                @if($pengaduans->count() > 0)
                    <div class="table-responsive">
                        <table class="mono-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Lokasi</th>
                                    <th>Barang</th>
                                    <th class="hide-mobile">Tanggal</th>
                                    <th>Status</th>
                                    <th class="hide-mobile">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengaduans->take(10) as $pengaduan)
                                <tr>
                                    <td><strong>#{{ $pengaduan->id }}</strong></td>
                                    <td>{{ $pengaduan->lokasi }}</td>
                                    <td>{{ $pengaduan->barang }}</td>
                                    <td class="hide-mobile">{{ $pengaduan->created_at->format('d M Y, H:i') }} WIB</td>
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
                                <td class="hide-mobile">
                                    @if($pengaduan->catatan_petugas)
                                        {{ Str::limit($pengaduan->catatan_petugas, 50) }}
                                    @else
                                        <span style="color: var(--color-gray-400);">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                @else
                    <div style="text-align: center; padding: 4rem 0; border: 1px solid var(--color-gray-200);">
                        <h3 style="color: var(--color-gray-500); font-weight: 400;">Belum ada pengaduan</h3>
                        <p style="color: var(--color-gray-400); margin-bottom: 2rem;">Mulai buat laporan pengaduan baru</p>
                        <a href="{{ route('pengaduan.create') }}" class="mono-btn mono-btn-primary">Buat Laporan Baru</a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                <h6 style="margin-bottom: 2rem; color: var(--color-gray-600);">Quick Actions</h6>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <a href="{{ route('pengaduan.create') }}" class="mono-card" style="text-decoration: none;">
                        <div class="mono-card-title">Buat Laporan</div>
                        <div class="mono-card-body">Laporkan kerusakan atau masalah fasilitas</div>
                    </a>
                    <a href="{{ route('pengaduan.index') }}" class="mono-card" style="text-decoration: none;">
                        <div class="mono-card-title">Lihat Semua</div>
                        <div class="mono-card-body">Pantau semua pengaduan yang telah dibuat</div>
                    </a>
                </div>
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

        // Smooth scroll behavior
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
