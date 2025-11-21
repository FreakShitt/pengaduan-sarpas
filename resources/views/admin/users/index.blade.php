<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Users — Pengaduan Sarpas</title>
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
                    <li><a href="{{ route('admin.users.index') }}" class="active">Users</a></li>
                    <li><a href="{{ route('admin.petugas.index') }}">Petugas</a></li>
                    <li><a href="{{ route('admin.lokasi.index') }}">Lokasi</a></li>
                    <li><a href="{{ route('admin.barang.index') }}">Barang</a></li>
                    <li><a href="{{ route('admin.item-requests.index') }}">Item Requests</a></li>
                    <li><a href="{{ route('admin.backups.index') }}">Backup</a></li>
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
                        <h1 style="font-size: 4rem; margin-bottom: 1rem;">KELOLA USERS</h1>
                        <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                            Manajemen Data Siswa & Guru
                        </p>
                    </div>
                    <a href="{{ route('admin.users.create') }}" class="mono-btn mono-btn-lg">
                        <svg style="width: 20px; height: 20px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        TAMBAH USER
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
                        <div class="mono-stat-number">{{ $siswa->count() + $guru->count() }}</div>
                        <div class="mono-stat-label">Total Users</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $siswa->count() }}</div>
                        <div class="mono-stat-label">Siswa</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ $guru->count() }}</div>
                        <div class="mono-stat-label">Guru</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Siswa Section -->
        <section class="mono-section">
            <div class="mono-container">
                <h2 style="margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
                    <span style="font-size: 2rem;">🎓</span>
                    SISWA ({{ $siswa->count() }})
                </h2>
                
                @if($siswa->count() > 0)
                    <table class="mono-table">
                        <thead>
                            <tr>
                                <th>NAMA</th>
                                <th>USERNAME</th>
                                <th>TANGGAL DAFTAR</th>
                                <th>TOTAL PENGADUAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa as $s)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--color-red-500) 0%, var(--color-red-600) 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem;">
                                            {{ strtoupper(substr($s->nama_pengguna, 0, 1)) }}
                                        </div>
                                        <strong>{{ $s->nama_pengguna }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <code style="background: var(--color-gray-100); padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.875rem; font-family: 'Courier New', monospace;">
                                        {{ $s->username }}
                                    </code>
                                </td>
                                <td style="color: var(--color-gray-600);">{{ $s->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="mono-badge" style="background: var(--color-blue-50); color: var(--color-blue-600);">
                                        {{ $s->pengaduans->count() }} Pengaduan
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; padding: 4rem 0; border: 2px solid var(--color-gray-200);">
                        <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.2;">🎓</div>
                        <p style="color: var(--color-gray-600);">Belum ada siswa terdaftar</p>
                    </div>
                @endif
            </div>
        </section>

        <!-- Guru Section -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                <h2 style="margin-bottom: 2rem;">
                    GURU ({{ $guru->count() }})
                </h2>
                
                @if($guru->count() > 0)
                    <table class="mono-table">
                        <thead>
                            <tr>
                                <th>NAMA</th>
                                <th>USERNAME</th>
                                <th>TANGGAL DAFTAR</th>
                                <th>TOTAL PENGADUAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guru as $g)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--color-blue-500) 0%, var(--color-blue-600) 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem;">
                                            {{ strtoupper(substr($g->nama_pengguna, 0, 1)) }}
                                        </div>
                                        <strong>{{ $g->nama_pengguna }}</strong>
                                    </div>
                                </td>
                                <td>
                                    <code style="background: var(--color-gray-100); padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.875rem; font-family: 'Courier New', monospace;">
                                        {{ $g->username }}
                                    </code>
                                </td>
                                <td style="color: var(--color-gray-600);">{{ $g->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <span class="mono-badge" style="background: var(--color-blue-50); color: var(--color-blue-600);">
                                        {{ $g->pengaduans->count() }} Pengaduan
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="text-align: center; padding: 4rem 0; border: 2px solid var(--color-gray-200);">
                        <div style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.2;">�</div>
                        <p style="color: var(--color-gray-600);">Belum ada guru terdaftar</p>
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
