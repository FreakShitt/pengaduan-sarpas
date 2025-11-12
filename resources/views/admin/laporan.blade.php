<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan — Pengaduan Sarpas</title>
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
                    <li><a href="{{ route('admin.laporan') }}" class="active">Laporan</a></li>
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
                <h1 style="font-size: 4rem; margin-bottom: 1rem;">LAPORAN PENGADUAN</h1>
                <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                    Review & Monitor Semua Laporan Pengaduan
                </p>
            </div>
        </section>

        <!-- Stats -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                <div class="mono-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));">
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $stats['total'] }}</div>
                        <div class="mono-stat-label">Total Laporan</div>
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

        <!-- Filter & Export -->
        <section class="mono-section">
            <div class="mono-container">
                <form method="GET" action="{{ route('admin.laporan') }}" style="margin-bottom: 2rem;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-gray-700); margin-bottom: 0.5rem;">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                                style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: 8px; font-size: 0.9375rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-gray-700); margin-bottom: 0.5rem;">Tanggal Akhir</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                                style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: 8px; font-size: 0.9375rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-gray-700); margin-bottom: 0.5rem;">Status</label>
                            <select name="status" style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: 8px; font-size: 0.9375rem; background: white;">
                                <option value="">Semua</option>
                                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-gray-700); margin-bottom: 0.5rem;">Lokasi</label>
                            <select name="lokasi" style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: 8px; font-size: 0.9375rem; background: white;">
                                <option value="">Semua Lokasi</option>
                                @foreach($lokasiList as $lok)
                                    <option value="{{ $lok->nama_lokasi }}" {{ request('lokasi') == $lok->nama_lokasi ? 'selected' : '' }}>{{ $lok->nama_lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="mono-btn">Filter</button>
                        <a href="{{ route('admin.laporan') }}" class="mono-btn mono-btn-ghost">Reset</a>
                    </div>
                </form>

                <!-- Export Buttons -->
                <div style="display: flex; gap: 1rem; padding: 1.5rem; background: var(--color-gray-50); border-radius: 8px; border: 1px solid var(--color-gray-200);">
                    <a href="{{ route('admin.laporan.export-pdf', request()->all()) }}" target="_blank" 
                        class="mono-btn" style="background: var(--color-red-600); color: white;">
                        <svg style="width: 18px; height: 18px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        Export PDF
                    </a>
                    <a href="{{ route('admin.laporan.export-doc', request()->all()) }}" 
                        class="mono-btn" style="background: var(--color-blue-600); color: white;">
                        <svg style="width: 18px; height: 18px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export DOC
                    </a>
                </div>
                </div>
            </div>
        </section>

        <!-- Data Table -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                @if($laporan->count() > 0)
                    <table class="mono-table">
                        <thead>
                            <tr>
                                <th>TANGGAL</th>
                                <th>PENGADU</th>
                                <th>LOKASI</th>
                                <th>BARANG</th>
                                <th>DETAIL</th>
                                <th>STATUS</th>
                                <th>PETUGAS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $l)
                            <tr>
                                <td style="white-space: nowrap; color: var(--color-gray-600);">{{ $l->created_at->format('d/m/Y H:i') }}</td>
                                <td><strong>{{ $l->user->nama_pengguna }}</strong></td>
                                <td>
                                    <span class="mono-badge">
                                        {{ $l->lokasi }}
                                    </span>
                                </td>
                                <td>{{ $l->barang }}</td>
                                <td style="max-width: 300px; color: var(--color-gray-600);">{{ Str::limit($l->detail_laporan, 50) }}</td>
                                <td>
                                    @if($l->status === 'diajukan')
                                        <span class="mono-badge">Diajukan</span>
                                    @elseif($l->status === 'diproses')
                                        <span class="mono-badge">Diproses</span>
                                    @elseif($l->status === 'selesai')
                                        <span class="mono-badge mono-badge-filled">Selesai</span>
                                    @elseif($l->status === 'ditolak')
                                        <span class="mono-badge mono-badge-outlined">Ditolak</span>
                                    @else
                                        <span class="mono-badge">{{ ucfirst($l->status ?? 'N/A') }}</span>
                                    @endif
                                </td>
                                <td style="color: var(--color-gray-600);">{{ $l->petugas ? $l->petugas->nama_pengguna : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="margin-top: 2rem;">
                        {{ $laporan->links() }}
                    </div>
                @else
                    <div style="text-align: center; padding: 6rem 0; border: 2px solid var(--color-gray-200);">
                        <div style="font-size: 6rem; margin-bottom: 1.5rem; opacity: 0.2;">📋</div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Tidak ada laporan ditemukan</h3>
                        <p style="color: var(--color-gray-600);">Coba ubah filter pencarian</p>
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
    </script>
</body>
</html>