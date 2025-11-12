<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan - {{ $pengaduan->lokasi }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1a1a1a;
            --secondary: #2d2d2d;
            --accent: #c5975f;
            --text-primary: #1a1a1a;
            --text-secondary: #666666;
            --text-tertiary: #999999;
            --border: #e8e8e8;
            --bg-light: #fafafa;
            --bg-white: #ffffff;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-light);
            color: var(--text-primary);
            line-height: 1.6;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 2rem 2rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .logo::before {
            content: '';
            width: 40px;
            height: 40px;
            background: var(--accent);
            border-radius: 6px;
        }

        .user-info {
            padding-top: 1rem;
        }

        .user-name {
            color: white;
            font-size: 0.9375rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .user-role {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8125rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .nav-menu {
            flex: 1;
            padding: 2rem 0;
            overflow-y: auto;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 2rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.9375rem;
            border-left: 3px solid transparent;
            gap: 0.875rem;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
        }

        .nav-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
        }

        .logout-section {
            padding: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.875rem;
            background: rgba(220, 47, 47, 0.1);
            color: #ff6b6b;
            border: 1px solid rgba(220, 47, 47, 0.2);
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: rgba(220, 47, 47, 0.15);
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
        }

        .header {
            background: var(--bg-white);
            padding: 2rem 3rem;
            border-bottom: 1px solid var(--border);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--bg-light);
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: var(--border);
            transform: translateX(-3px);
        }

        .header-title h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .header-subtitle {
            color: var(--text-secondary);
            font-size: 0.9375rem;
        }

        /* Content */
        .content-area {
            padding: 3rem;
            max-width: 1200px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .detail-card {
            background: var(--bg-white);
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 2rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        }

        .card-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .detail-row {
            margin-bottom: 1.5rem;
        }

        .detail-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            font-size: 1rem;
            color: var(--text-primary);
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending { background: #FEF3C7; color: #92400E; }
        .status-diajukan { background: #FEF3C7; color: #92400E; }
        .status-proses { background: #DBEAFE; color: #1E40AF; }
        .status-diproses { background: #DBEAFE; color: #1E40AF; }
        .status-selesai { background: #D1FAE5; color: #065F46; }
        .status-ditolak { background: #FEE2E2; color: #991B1B; }

        /* Image Display */
        .image-container {
            margin-top: 1rem;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border);
        }

        .image-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        .no-image {
            padding: 3rem;
            text-align: center;
            background: var(--bg-light);
            color: var(--text-tertiary);
            font-size: 0.875rem;
        }

        /* Info Box */
        .info-box {
            background: rgba(197, 151, 95, 0.1);
            border: 1px solid rgba(197, 151, 95, 0.3);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }

        .info-box p {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .content-area {
                padding: 2rem 1.5rem;
            }

            .header {
                padding: 1.5rem;
            }

            .detail-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">SARPAS</div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->nama_pengguna }}</div>
                <div class="user-role">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('pengaduan.index') }}" class="nav-item active">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Laporan Saya
            </a>
        </nav>

        <div class="logout-section">
            <a href="{{ route('logout') }}" class="logout-btn" onclick="return confirm('Keluar dari sistem?')">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="header">
            <div class="header-top">
                <a href="{{ route('pengaduan.index') }}" class="back-btn">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
            <div class="header-title">
                <h1>Detail Laporan</h1>
                <p class="header-subtitle">Informasi lengkap pengaduan fasilitas</p>
            </div>
        </header>

        <div class="content-area">
            <div class="detail-grid">
                <!-- Main Info -->
                <div class="detail-card">
                    <div class="card-header">
                        <h2>Informasi Laporan</h2>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Kode Laporan</div>
                        <div class="detail-value">#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Status</div>
                        <div class="detail-value">
                            @php
                                $statusClass = 'status-' . strtolower($pengaduan->status);
                                $statusText = $pengaduan->status;
                                if ($pengaduan->status == 'diajukan') $statusText = 'Pending';
                                elseif ($pengaduan->status == 'proses' || $pengaduan->status == 'diproses') $statusText = 'Diproses';
                                elseif ($pengaduan->status == 'selesai') $statusText = 'Selesai';
                                elseif ($pengaduan->status == 'ditolak') $statusText = 'Ditolak';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                        </div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Lokasi</div>
                        <div class="detail-value">📍 {{ $pengaduan->lokasi }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Barang/Fasilitas</div>
                        <div class="detail-value">🔧 {{ $pengaduan->barang }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Detail Kerusakan</div>
                        <div class="detail-value">{{ $pengaduan->detail_laporan }}</div>
                    </div>

                    <div class="detail-row">
                        <div class="detail-label">Tanggal Laporan</div>
                        <div class="detail-value">📅 {{ \Carbon\Carbon::parse($pengaduan->tanggal_laporan)->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }}</div>
                    </div>

                    @if($pengaduan->petugas_id && $pengaduan->petugas)
                    <div class="detail-row">
                        <div class="detail-label">Ditangani Oleh</div>
                        <div class="detail-value">👤 {{ $pengaduan->petugas->nama_pengguna }}</div>
                    </div>
                    @endif

                    @if($pengaduan->catatan_petugas)
                    <div class="info-box">
                        <div class="detail-label">Catatan Petugas</div>
                        <p>{{ $pengaduan->catatan_petugas }}</p>
                    </div>
                    @endif
                </div>

                <!-- Image -->
                <div class="detail-card">
                    <div class="card-header">
                        <h2>Bukti Foto</h2>
                    </div>

                    <div class="image-container">
                        @if($pengaduan->gambar)
                            <img src="{{ asset('uploads/pengaduan/' . $pengaduan->gambar) }}" alt="Foto Kerusakan">
                        @else
                            <div class="no-image">
                                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 auto 1rem;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p>Tidak ada foto dilampirkan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
