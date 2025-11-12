<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Petugas — Pengaduan Sarpas</title>
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
                    <li><a href="{{ route('admin.petugas.index') }}" class="active">Petugas</a></li>
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
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <h1 style="font-size: 4rem; margin-bottom: 1rem;">KELOLA PETUGAS</h1>
                        <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                            Manajemen Data Petugas & Monitoring Kinerja
                        </p>
                    </div>
                    <a href="{{ route('admin.petugas.create') }}" class="mono-btn mono-btn-lg">
                        <svg style="width: 20px; height: 20px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        TAMBAH PETUGAS
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

        <!-- Stats -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                <div class="mono-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $petugas->count() }}</div>
                        <div class="mono-stat-label">Total Petugas</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $petugas->sum('total_handled') }}</div>
                        <div class="mono-stat-label">Total Ditangani</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $petugas->sum('completed') }}</div>
                        <div class="mono-stat-label">Selesai</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $petugas->sum('in_progress') }}</div>
                        <div class="mono-stat-label">Dalam Proses</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Data Table -->
        <section class="mono-section">
            <div class="mono-container">
                @if($petugas->count() > 0)
                    <table class="mono-table">
                        <thead>
                            <tr>
                                <th>NAMA PETUGAS</th>
                                <th>USERNAME</th>
                                <th>TANGGAL DAFTAR</th>
                                <th style="text-align: center;">DITANGANI</th>
                                <th style="text-align: center;">SELESAI</th>
                                <th style="text-align: center;">PROSES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($petugas as $p)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--color-yellow-500) 0%, var(--color-yellow-600) 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem;">
                                            {{ strtoupper(substr($p->nama_pengguna, 0, 1)) }}
                                        </div>
                                        <strong>{{ $p->nama_pengguna }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <code style="background: var(--color-gray-100); padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.875rem; font-family: 'Courier New', monospace;">
                                        {{ $p->username }}
                                    </code>
                                </td>
                                <td style="color: var(--color-gray-600);">{{ $p->created_at->format('d/m/Y') }}</td>
                                <td style="text-align: center;">
                                    <span class="mono-badge" style="background: var(--color-blue-50); color: var(--color-blue-600);">
                                        {{ $p->total_handled }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="mono-badge mono-badge-filled">
                                        {{ $p->completed }}
                                    </span>
                                </td>
                                <td style="text-align: center;">
                                    <span class="mono-badge">
                                        {{ $p->in_progress }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; padding: 6rem 0; border: 2px solid var(--color-gray-200);">
                        <div style="font-size: 6rem; margin-bottom: 1.5rem; opacity: 0.2;">�</div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Belum ada petugas terdaftar</h3>
                        <p style="color: var(--color-gray-600); margin-bottom: 2rem;">Mulai dengan menambahkan petugas pertama Anda</p>
                        <a href="{{ route('admin.petugas.create') }}" class="mono-btn">TAMBAH PETUGAS</a>
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
            const alerts = document.querySelectorAll('[style*="color-green-50"]');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
