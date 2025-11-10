<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Pengaduan Sarana & Prasarana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            overflow-y: auto;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 2rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .sidebar-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #c5975f;
        }

        .sidebar-subtitle {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 300;
        }

        .nav-menu {
            list-style: none;
            padding: 0 1rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(197, 151, 95, 0.1);
            color: #c5975f;
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%);
            color: white;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 1rem;
        }

        .badge-notification {
            background: #ef4444;
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            margin-left: 0.5rem;
            font-weight: 600;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 2rem;
        }

        /* Header */
        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-name {
            font-weight: 600;
            color: #1a1a1a;
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
            letter-spacing: 0.02em;
        }

        .logout-btn:hover {
            background: rgba(220, 47, 47, 0.15);
            border-color: rgba(220, 47, 47, 0.3);
        }

        /* Stats Grid */
        .stats-bar {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #e8e8e8;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .stats-grid {
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
        }

        .stat-card {
            flex: 1;
            min-width: 130px;
            padding: 1rem 1.25rem;
            border-right: 1px solid #e8e8e8;
            position: relative;
            transition: all 0.2s ease;
            background: white;
        }

        .stat-card:last-child {
            border-right: none;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #c5975f 0%, #d4a76a 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            background: linear-gradient(180deg, #ffffff 0%, #fafaf8 100%);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-label {
            font-size: 0.7rem;
            color: #666;
            margin-bottom: 0.4rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
            font-family: 'Playfair Display', serif;
            line-height: 1;
            margin-bottom: 0.2rem;
        }

        .stat-change {
            font-size: 0.65rem;
            color: #999;
            margin-top: 0.2rem;
            line-height: 1.2;
        }

        @media (max-width: 1400px) {
            .stats-grid {
                flex-wrap: wrap;
            }
            .stat-card {
                min-width: 150px;
                border-right: 1px solid #e8e8e8;
                border-bottom: 1px solid #e8e8e8;
            }
            .stat-card:nth-child(5n) {
                border-right: none;
            }
        }

        @media (max-width: 768px) {
            .stat-card {
                flex: 1 1 50%;
                border-right: 1px solid #e8e8e8;
            }
            .stat-card:nth-child(2n) {
                border-right: none;
            }
        }

        /* Content Sections */
        .content-section {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
        }

        /* Table Styles */
        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: white;
        }

        .data-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table th:first-child {
            border-top-left-radius: 12px;
        }

        .data-table th:last-child {
            border-top-right-radius: 12px;
        }

        .data-table tbody tr {
            border-bottom: 1px solid #e8e8e8;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .data-table tbody tr:hover {
            background: #f5f5f5;
        }

        .data-table td {
            padding: 1rem;
            color: #333;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-proses {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-selesai {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-ditolak {
            background: #FEE2E2;
            color: #991B1B;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="sidebar-title">Admin Panel</h1>
                <p class="sidebar-subtitle">Sistem Pengaduan Sarpras</p>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.petugas') }}" class="nav-link">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Kelola Petugas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users') }}" class="nav-link">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Kelola Pengguna
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.lokasi') }}" class="nav-link">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Kelola Lokasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.barang') }}" class="nav-link">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Kelola Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.item-requests') }}" class="nav-link">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            Permintaan Item Baru
                            @php
                                $pendingCount = \App\Models\ItemRequest::where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="badge-notification">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.laporan') }}" class="nav-link">
                            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Laporan
                        </a>
                    </li>
                </ul>

                <!-- Logout Section -->
                <div class="logout-section">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn" onclick="return confirm('Keluar dari sistem?')">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <div class="page-header">
                <div class="header-top">
                    <h1 class="page-title">Dashboard Administrator</h1>
                    <div class="user-info">
                        <span class="user-name">👤 {{ Auth::user()->nama_pengguna }}</span>
                    </div>
                </div>
            </div>

            <!-- Statistics Bar -->
            <div class="stats-bar">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">Total Pengaduan</div>
                        <div class="stat-value">{{ $totalReports }}</div>
                        <div class="stat-change">Semua pengaduan</div>
                    </div>
                <div class="stat-card">
                    <div class="stat-label">Menunggu Verifikasi</div>
                    <div class="stat-value">{{ $pendingReports }}</div>
                    <div class="stat-change">Perlu ditinjau</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Dalam Proses</div>
                    <div class="stat-value">{{ $processingReports }}</div>
                    <div class="stat-change">Sedang ditangani</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Selesai</div>
                    <div class="stat-value">{{ $completedReports }}</div>
                    <div class="stat-change">Berhasil diselesaikan</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Siswa</div>
                    <div class="stat-value">{{ $totalSiswa }}</div>
                    <div class="stat-change">Pengguna aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Guru</div>
                    <div class="stat-value">{{ $totalGuru }}</div>
                    <div class="stat-change">Pengguna aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Total Petugas</div>
                    <div class="stat-value">{{ $totalPetugas }}</div>
                    <div class="stat-change">Teknisi terdaftar</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Lokasi Terdaftar</div>
                    <div class="stat-value">{{ $totalLokasi }}</div>
                    <div class="stat-change">Lokasi aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Barang Terdaftar</div>
                    <div class="stat-value">{{ $totalBarang }}</div>
                    <div class="stat-change">Item aktif</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Ditolak</div>
                    <div class="stat-value">{{ $rejectedReports }}</div>
                    <div class="stat-change">Tidak dapat diproses</div>
                </div>
                </div>
            </div>

            <!-- Recent Reports Section -->
            <div class="content-section">
                <h2 class="section-title">Pengaduan Terbaru</h2>
                @if($recentReports->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelapor</th>
                                <th>Lokasi</th>
                                <th>Barang</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentReports as $report)
                            <tr>
                                <td>{{ $report->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $report->user->nama_pengguna }}</td>
                                <td>{{ $report->lokasi }}</td>
                                <td>{{ $report->barang }}</td>
                                <td>{{ Str::limit($report->deskripsi_masalah, 50) }}</td>
                                <td>
                                    @if($report->status === 'diajukan')
                                        <span class="status-badge status-pending">Diajukan</span>
                                    @elseif($report->status === 'diproses')
                                        <span class="status-badge status-proses">Diproses</span>
                                    @elseif($report->status === 'selesai')
                                        <span class="status-badge status-selesai">Selesai</span>
                                    @elseif($report->status === 'ditolak')
                                        <span class="status-badge status-ditolak">Ditolak</span>
                                    @else
                                        <span class="status-badge">{{ ucfirst($report->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $report->petugas ? $report->petugas->nama_pengguna : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <p>Belum ada pengaduan terbaru</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
