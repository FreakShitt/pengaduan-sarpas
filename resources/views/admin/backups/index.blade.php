<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup Database — Pengaduan Sarpas</title>
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
                    <li><a href="{{ route('admin.barang.index') }}">Barang</a></li>
                    <li><a href="{{ route('admin.item-requests.index') }}">Item Requests</a></li>
                    <li><a href="{{ route('admin.backups.index') }}" class="active">Backup</a></li>
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
                        <h1 style="font-size: 4rem; margin-bottom: 1rem;">BACKUP DATABASE</h1>
                        <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                            Manajemen Backup Database Otomatis & Manual
                        </p>
                    </div>
                    <form action="{{ route('admin.backups.create') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="mono-btn mono-btn-lg" onclick="return confirm('Buat backup database sekarang?')">
                            <svg style="width: 20px; height: 20px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            BUAT BACKUP SEKARANG
                        </button>
                    </form>
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

        <!-- Info Box -->
        <section class="mono-section" style="background: var(--color-blue-50);">
            <div class="mono-container">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div style="background: white; padding: 2rem; border-radius: 12px; border: 2px solid var(--color-gray-200);">
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">🔄 Backup Otomatis</h3>
                        <p style="color: var(--color-gray-600); margin-bottom: 1rem;">
                            Sistem akan otomatis membuat backup database setiap hari pada pukul <strong>02:00 WIB</strong>
                        </p>
                        <div style="background: var(--color-gray-50); padding: 1rem; border-radius: 8px; font-family: monospace; font-size: 0.875rem;">
                            Schedule: Daily at 02:00<br>
                            Retention: 30 days<br>
                            Status: Active ✓
                        </div>
                    </div>
                    <div style="background: white; padding: 2rem; border-radius: 12px; border: 2px solid var(--color-gray-200);">
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">💾 Backup Manual</h3>
                        <p style="color: var(--color-gray-600); margin-bottom: 1rem;">
                            Klik tombol <strong>"BUAT BACKUP SEKARANG"</strong> untuk membuat backup kapan saja
                        </p>
                        <div style="background: var(--color-gray-50); padding: 1rem; border-radius: 8px; font-family: monospace; font-size: 0.875rem;">
                            Format: backup_YYYY-MM-DD_HHMMSS.sql<br>
                            Include: Tables + SP + Triggers<br>
                            Location: storage/app/backups/
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                <div class="mono-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ count($backups) }}</div>
                        <div class="mono-stat-label">Total Backup Files</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">
                            @php
                                $totalSize = 0;
                                foreach($backups as $backup) {
                                    $totalSize += filesize($backup['path']);
                                }
                                echo $totalSize > 0 ? number_format($totalSize / (1024*1024), 2) . ' MB' : '0 MB';
                            @endphp
                        </div>
                        <div class="mono-stat-label">Total Size</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ count($backups) > 0 ? \Carbon\Carbon::parse($backups[0]['date'])->diffForHumans() : '-' }}</div>
                        <div class="mono-stat-label">Latest Backup</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Backup List -->
        <section class="mono-section">
            <div class="mono-container">
                <h2 style="font-size: 2rem; margin-bottom: 2rem;">DAFTAR BACKUP</h2>

                @if(count($backups) > 0)
                    <table class="mono-table">
                        <thead>
                            <tr>
                                <th style="width: 60px; text-align: center;">NO</th>
                                <th>NAMA FILE</th>
                                <th>TANGGAL & WAKTU</th>
                                <th>UKURAN</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($backups as $index => $backup)
                            <tr>
                                <td style="text-align: center; font-weight: 600;">{{ $index + 1 }}</td>
                                <td>
                                    <strong style="font-family: monospace; color: var(--color-blue-600);">{{ $backup['name'] }}</strong>
                                </td>
                                <td>
                                    <span class="mono-badge">
                                        {{ \Carbon\Carbon::parse($backup['date'])->format('d M Y, H:i:s') }}
                                    </span>
                                    <span style="font-size: 0.8125rem; color: var(--color-gray-500); margin-left: 0.5rem;">
                                        ({{ \Carbon\Carbon::parse($backup['date'])->diffForHumans() }})
                                    </span>
                                </td>
                                <td style="font-weight: 600; color: var(--color-gray-700);">{{ $backup['size'] }}</td>
                                <td style="text-align: center;">
                                    <div style="display: inline-flex; gap: 0.5rem;">
                                        <a href="{{ route('admin.backups.download', $backup['name']) }}" 
                                           class="mono-btn mono-btn-sm" 
                                           style="background: var(--color-green-50); color: var(--color-green-600);">
                                            <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Download
                                        </a>
                                        <form action="{{ route('admin.backups.delete', $backup['name']) }}" method="POST" style="display: inline;"
                                              onsubmit="return confirm('Yakin ingin menghapus backup ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="mono-btn mono-btn-sm" style="background: var(--color-red-50); color: var(--color-red-600);">
                                                <svg style="width: 16px; height: 16px; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
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
                    <div style="text-align: center; padding: 6rem 0; border: 2px solid var(--color-gray-200);">
                        <div style="font-size: 6rem; margin-bottom: 1.5rem; opacity: 0.2;">💾</div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Belum ada backup</h3>
                        <p style="color: var(--color-gray-600); margin-bottom: 2rem;">Buat backup pertama Anda sekarang</p>
                        <form action="{{ route('admin.backups.create') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="mono-btn">BUAT BACKUP SEKARANG</button>
                        </form>
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

        // Auto hide success/error alerts after 5 seconds
        setTimeout(() => {
            const successAlerts = document.querySelectorAll('section > div > div[style*="color-green-50"][style*="border-left"]');
            const errorAlerts = document.querySelectorAll('section > div > div[style*="color-red-50"][style*="border-left"]');
            
            [...successAlerts, ...errorAlerts].forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>
