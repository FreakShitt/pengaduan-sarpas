<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pengaduan Sarana dan Prasarana</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f3f4f6; }
        
        /* Sidebar Styles */
        .sidebar { 
            width: 260px; 
            background: linear-gradient(180deg, #1e3a8a 0%, #1e40af 100%); 
            height: 100vh; 
            position: fixed; 
            left: 0; 
            top: 0; 
            color: white;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        
        .sidebar-header { 
            padding: 2rem 1.5rem; 
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h1 { 
            margin: 0; 
            font-size: 1.5rem; 
            font-weight: 700;
            color: white;
        }
        
        .sidebar-header p { 
            margin: 0.5rem 0 0 0; 
            font-size: 0.875rem; 
            opacity: 0.8;
        }
        
        .nav-menu { 
            flex: 1; 
            padding: 1rem 0;
        }
        
        .nav-item { 
            display: flex; 
            align-items: center; 
            padding: 0.875rem 1.5rem; 
            color: rgba(255,255,255,0.8); 
            text-decoration: none; 
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .nav-item:hover, .nav-item.active { 
            background: rgba(255,255,255,0.1); 
            color: white;
            border-left-color: #60a5fa;
        }
        
        .nav-item svg { 
            width: 20px; 
            height: 20px; 
            margin-right: 0.875rem;
        }
        
        .logout-section { 
            padding: 1rem 1.5rem; 
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .logout-btn { 
            display: flex; 
            align-items: center; 
            justify-content: center;
            width: 100%; 
            padding: 0.75rem; 
            background: rgba(239, 68, 68, 0.2); 
            color: white; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            transition: all 0.2s;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .logout-btn:hover { 
            background: rgba(239, 68, 68, 0.3);
        }
        
        .logout-btn svg { 
            width: 18px; 
            height: 18px; 
            margin-right: 0.5rem;
        }
        
        /* Main Content */
        .main-content { 
            margin-left: 260px; 
            min-height: 100vh;
        }
        
        .header { 
            background: white; 
            padding: 1.5rem 2rem; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-title h1 { 
            margin: 0; 
            font-size: 1.875rem; 
            color: #111827; 
            font-weight: 700;
        }
        
        .header-title p { 
            margin: 0.25rem 0 0 0; 
            color: #6b7280; 
            font-size: 0.875rem;
        }
        
        .user-badge { 
            background: #dbeafe; 
            color: #1e40af; 
            padding: 0.5rem 1rem; 
            border-radius: 9999px; 
            font-size: 0.875rem; 
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .content-area { 
            padding: 2rem; 
        }
        
        /* Stats Grid */
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); 
            gap: 1.5rem; 
            margin-bottom: 2rem;
        }
        
        .stat-card { 
            background: white; 
            padding: 1.75rem; 
            border-radius: 16px; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }
        
        .stat-icon { 
            width: 52px; 
            height: 52px; 
            border-radius: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center;
        }
        
        .stat-icon svg {
            width: 26px;
            height: 26px;
        }
        
        .stat-card h3 { 
            color: #6b7280; 
            font-size: 0.875rem; 
            font-weight: 600; 
            margin: 0 0 0.5rem 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .stat-card .value { 
            font-size: 2.5rem; 
            font-weight: 700; 
            color: #111827; 
            margin: 0;
            line-height: 1;
        }
        
        .stat-card .change {
            font-size: 0.875rem;
            color: #10b981;
            margin-top: 0.5rem;
        }
        
        /* Recent Section */
        .recent-section { 
            background: white; 
            padding: 2rem; 
            border-radius: 16px; 
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .recent-section h2 { 
            margin: 0; 
            font-size: 1.5rem; 
            color: #111827; 
            font-weight: 700;
        }
        
        .view-all-btn {
            background: #f3f4f6;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            transition: background 0.2s;
        }
        
        .view-all-btn:hover {
            background: #e5e7eb;
        }
        
        .table-container { 
            overflow-x: auto; 
        }
        
        table { 
            width: 100%; 
            border-collapse: separate;
            border-spacing: 0;
        }
        
        th { 
            text-align: left; 
            padding: 1rem; 
            background: #f9fafb; 
            color: #6b7280; 
            font-weight: 700; 
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e5e7eb;
        }
        
        th:first-child { border-radius: 8px 0 0 0; }
        th:last-child { border-radius: 0 8px 0 0; }
        
        td { 
            padding: 1rem; 
            border-bottom: 1px solid #f3f4f6;
            color: #374151;
        }
        
        tr:last-child td { border-bottom: none; }
        
        tr:hover td {
            background: #f9fafb;
        }
        
        .badge { 
            padding: 0.375rem 0.875rem; 
            border-radius: 9999px; 
            font-size: 0.75rem; 
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .badge-pending { 
            background: #fef3c7; 
            color: #92400e; 
        }
        
        .badge-process { 
            background: #dbeafe; 
            color: #1e40af; 
        }
        
        .badge-completed { 
            background: #d1fae5; 
            color: #065f46; 
        }
        
        .priority-high { color: #dc2626; font-weight: 600; }
        .priority-medium { color: #f59e0b; font-weight: 600; }
        .priority-low { color: #10b981; font-weight: 600; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 100%; height: auto; position: relative; }
            .main-content { margin-left: 0; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h1>📋 Sarpas</h1>
            <p>Sistem Pengaduan</p>
        </div>
        
        <nav class="nav-menu">
            <a href="{{ route('dashboard') }}" class="nav-item active">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            
            <a href="{{ route('pengaduan.index') }}" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Pengaduan
            </a>
            
            <a href="#" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Laporan
            </a>
            
            <a href="#" class="nav-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Pengaturan
            </a>
        </nav>
        
        <div class="logout-section">
            <a href="{{ route('logout') }}" class="logout-btn" onclick="return confirm('Yakin ingin logout?')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-title">
                <h1>Dashboard</h1>
                <p>Welcome back, <strong>{{ Auth::user()->nama_pengguna }}</strong></p>
            </div>
            <div class="user-badge">
                <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                {{ ucfirst(Auth::user()->role) }}
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <h3>Total Pengaduan</h3>
                            <p class="value">{{ $stats['total'] }}</p>
                            <p class="change">↗ Pengaduan Anda</p>
                        </div>
                        <div class="stat-icon" style="background: #dbeafe; color: #1e40af;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <h3>Diajukan</h3>
                            <p class="value">{{ $stats['diajukan'] }}</p>
                            <p class="change" style="color: #f59e0b;">⏱ Menunggu review</p>
                        </div>
                        <div class="stat-icon" style="background: #fef3c7; color: #d97706;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <h3>Diproses</h3>
                            <p class="value">{{ $stats['diproses'] }}</p>
                            <p class="change" style="color: #3b82f6;">⚡ Sedang ditangani</p>
                        </div>
                        <div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div>
                            <h3>Selesai</h3>
                            <p class="value">{{ $stats['selesai'] }}</p>
                            <p class="change">✓ Sudah diperbaiki</p>
                        </div>
                        <div class="stat-icon" style="background: #d1fae5; color: #059669;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Complaints -->
            <div class="recent-section">
                <div class="section-header">
                    <h2>📌 Pengaduan Terbaru</h2>
                    <a href="#" class="view-all-btn">Lihat Semua →</a>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>LOKASI</th>
                                <th>BARANG</th>
                                <th>TANGGAL</th>
                                <th>STATUS</th>
                                <th>CATATAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($pengaduans->count() > 0)
                                @foreach($pengaduans as $index => $pengaduan)
                                <tr>
                                    <td><strong>#{{ $pengaduan->id }}</strong></td>
                                    <td>{{ $pengaduan->lokasi }}</td>
                                    <td>{{ $pengaduan->barang }}</td>
                                    <td>{{ $pengaduan->created_at->format('d M Y, H:i') }} WIB</td>
                                    <td>
                                        @if($pengaduan->status == 'diajukan')
                                            <span class="badge badge-pending">Diajukan</span>
                                        @elseif($pengaduan->status == 'diproses')
                                            <span class="badge badge-process">Diproses</span>
                                        @elseif($pengaduan->status == 'selesai')
                                            <span class="badge badge-completed">Selesai</span>
                                        @elseif($pengaduan->status == 'ditolak')
                                            <span class="badge" style="background: #fee2e2; color: #991b1b;">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($pengaduan->catatan_petugas)
                                            <small style="color: #6b7280;">{{ Str::limit($pengaduan->catatan_petugas, 50) }}</small>
                                        @else
                                            <small style="color: #d1d5db;">-</small>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem; color: #6b7280;">
                                        <svg style="width: 64px; height: 64px; margin: 0 auto 1rem; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p style="margin: 0; font-size: 1rem;"><strong>Belum ada pengaduan</strong></p>
                                        <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem;">Buat pengaduan pertama Anda dengan klik menu Pengaduan</p>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</body>
</html>