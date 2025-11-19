<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — Pengaduan Sarpas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    <header class="mono-header">
        <div class="mono-container">
            <nav class="mono-nav">
                <div class="mono-logo">SARPAS / ADMIN</div>
                <ul class="mono-nav-links">
                    <li><a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a></li>
                    <li><a href="{{ route('admin.laporan') }}">Laporan</a></li>
                    <li><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li><a href="{{ route('admin.petugas.index') }}">Petugas</a></li>
                    <li><a href="{{ route('admin.lokasi.index') }}">Lokasi</a></li>
                    <li><a href="{{ route('admin.barang.index') }}">Barang</a></li>
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
                <h1 style="font-size: 4rem; margin-bottom: 1rem;">ADMIN DASHBOARD</h1>
                <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                    System Overview & Management
                </p>
            </div>
        </section>

        <!-- Main Statistics -->
        <section class="mono-section">
            <div class="mono-container">
                <h6 style="margin-bottom: 2rem; color: var(--color-gray-600);">Overview Sistem</h6>
                <div class="mono-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $totalReports }}</div>
                        <div class="mono-stat-label">Total Laporan</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $totalPetugas }}</div>
                        <div class="mono-stat-label">Petugas</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $totalSiswa }}</div>
                        <div class="mono-stat-label">Siswa</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $totalGuru }}</div>
                        <div class="mono-stat-label">Guru</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $totalLokasi }}</div>
                        <div class="mono-stat-label">Lokasi</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $totalBarang }}</div>
                        <div class="mono-stat-label">Barang</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Report Status Statistics -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                <h6 style="margin-bottom: 2rem; color: var(--color-gray-600);">Status Laporan</h6>
                <div class="mono-stats-grid">
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $pendingReports }}</div>
                        <div class="mono-stat-label">Diajukan</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $approvedReports }}</div>
                        <div class="mono-stat-label">Disetujui</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $completedReports }}</div>
                        <div class="mono-stat-label">Selesai</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $rejectedReports }}</div>
                        <div class="mono-stat-label">Ditolak</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Barang by Location Stats -->
        <section class="mono-section">
            <div class="mono-container">
                <h6 style="margin-bottom: 2rem; color: var(--color-gray-600);">Barang per Lokasi</h6>
                <div class="mono-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));">
                    @foreach($barangByLocation as $item)
                    <div class="mono-stat-card" style="padding: 1rem;">
                        <div class="mono-stat-number" style="font-size: 1.75rem;">{{ $item['total'] }}</div>
                        <div class="mono-stat-label" style="font-size: 0.75rem;">{{ $item['nama_lokasi'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Recent Reports -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h2 style="margin-bottom: 0;">RECENT REPORTS</h2>
                    <a href="{{ route('admin.laporan') }}" class="mono-btn mono-btn-ghost">View All →</a>
                </div>

                <!-- Filters -->
                <form method="GET" action="{{ route('admin.dashboard') }}" style="margin-bottom: 2rem;">
                    <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: end;">
                        <div style="margin-bottom: 0;">
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-gray-700); margin-bottom: 0.5rem;">Pencarian</label>
                            <input type="text" name="search" placeholder="Cari lokasi, barang, detail..." value="{{ request('search') }}"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: 8px; font-size: 0.9375rem; background: white;">
                        </div>
                        <div style="margin-bottom: 0;">
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-gray-700); margin-bottom: 0.5rem;">Status</label>
                            <select name="status" 
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: 8px; font-size: 0.9375rem; background: white;">
                                <option value="">Semua Status</option>
                                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 0;">
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-gray-700); margin-bottom: 0.5rem;">Lokasi</label>
                            <input type="text" name="lokasi" placeholder="Filter lokasi..." value="{{ request('lokasi') }}"
                                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: 8px; font-size: 0.9375rem; background: white;">
                        </div>
                        <div style="display: flex; gap: 0.5rem;">
                            <button type="submit" class="mono-btn">Filter</button>
                            <a href="{{ route('admin.dashboard') }}" class="mono-btn mono-btn-ghost">Reset</a>
                        </div>
                    </div>
                </form>
                </form>

                @if($recentReports->count() > 0)
                    <table class="mono-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pelapor</th>
                                <th>Lokasi</th>
                                <th>Barang</th>
                                <th>Detail</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentReports as $report)
                            <tr>
                                <td><strong>#{{ $report->id }}</strong></td>
                                <td>{{ $report->user ? $report->user->nama_pengguna : '-' }}</td>
                                <td>{{ $report->lokasi }}</td>
                                <td>{{ $report->barang }}</td>
                                <td style="max-width: 250px;">{{ Str::limit($report->detail_laporan, 50) }}</td>
                                <td>
                                    @if($report->status == 'diajukan')
                                        <span class="mono-badge">{{ ucfirst($report->status) }}</span>
                                    @elseif($report->status == 'diproses')
                                        <span class="mono-badge">{{ ucfirst($report->status) }}</span>
                                    @elseif($report->status == 'selesai')
                                        <span class="mono-badge mono-badge-filled">{{ ucfirst($report->status) }}</span>
                                    @else
                                        <span class="mono-badge mono-badge-outlined">{{ ucfirst($report->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $report->petugas ? $report->petugas->nama_pengguna : '-' }}</td>
                                <td style="white-space: nowrap;">{{ $report->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; padding: 4rem 0; border: 1px solid var(--color-gray-200);">
                        <h3 style="color: var(--color-gray-500); font-weight: 400;">Belum ada laporan</h3>
                    </div>
                @endif
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                <h6 style="margin-bottom: 2rem; color: var(--color-gray-600);">Quick Actions</h6>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                    <a href="{{ route('admin.laporan') }}" class="mono-card" style="text-decoration: none;">
                        <div class="mono-card-title">Kelola Laporan</div>
                        <div class="mono-card-body">Review dan update status laporan</div>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="mono-card" style="text-decoration: none;">
                        <div class="mono-card-title">Kelola User</div>
                        <div class="mono-card-body">Manajemen user siswa, guru, petugas</div>
                    </a>
                    <a href="{{ route('admin.petugas.index') }}" class="mono-card" style="text-decoration: none;">
                        <div class="mono-card-title">Kelola Petugas</div>
                        <div class="mono-card-body">Assign dan monitor petugas</div>
                    </a>
                    <a href="{{ route('admin.lokasi.index') }}" class="mono-card" style="text-decoration: none;">
                        <div class="mono-card-title">Lokasi & Barang</div>
                        <div class="mono-card-body">Kelola master data lokasi dan barang</div>
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
