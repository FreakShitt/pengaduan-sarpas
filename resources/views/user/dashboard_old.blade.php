<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Facility Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-light);
            color: var(--text-primary);
            line-height: 1.6;
            letter-spacing: -0.01em;
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
            box-shadow: var(--shadow-lg);
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
            letter-spacing: -0.02em;
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-size: 0.9375rem;
            font-weight: 400;
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
            stroke-width: 1.5px;
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

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
        }

        .header {
            background: var(--bg-white);
            padding: 2rem 3rem;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(10px);
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
        }

        .header-subtitle {
            color: var(--text-secondary);
            font-size: 0.9375rem;
            font-weight: 400;
        }

        .header-badge {
            background: var(--bg-light);
            color: var(--text-secondary);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid var(--border);
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        /* Content Area */
        .content-area {
            padding: 3rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--bg-white);
            padding: 2rem;
            border-radius: 12px;
            border: 1px solid var(--border);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover {
            box-shadow: var(--shadow);
            transform: translateY(-4px);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .stat-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon svg {
            width: 20px;
            height: 20px;
        }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .stat-caption {
            font-size: 0.875rem;
            color: var(--text-tertiary);
            font-weight: 400;
        }

        /* Table Section */
        .table-section {
            background: var(--bg-white);
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .table-header {
            padding: 2rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .view-all-btn {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.3s;
            letter-spacing: 0.02em;
        }

        .view-all-btn:hover {
            color: var(--primary);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--bg-light);
        }

        th {
            text-align: left;
            padding: 1rem 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 1.25rem 2rem;
            border-bottom: 1px solid var(--border);
            font-size: 0.9375rem;
            color: var(--text-primary);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tbody tr {
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: var(--bg-light);
        }

        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 500;
            letter-spacing: 0.02em;
        }

        .status-badge.diajukan {
            background: #fff4e6;
            color: #e67700;
            border: 1px solid #ffd699;
        }

        .status-badge.diproses {
            background: #e3f2fd;
            color: #1976d2;
            border: 1px solid #90caf9;
        }

        .status-badge.selesai {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .status-badge.ditolak {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-tertiary);
        }

        .empty-state svg {
            width: 64px;
            height: 64px;
            margin: 0 auto 1.5rem;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            font-size: 0.9375rem;
            color: var(--text-tertiary);
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }
        }

        @media (max-width: 768px) {
            .content-area {
                padding: 2rem 1.5rem;
            }

            .header {
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
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
            <a href="{{ route('dashboard') }}" class="nav-item active">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('pengaduan.index') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Reports
            </a>
        </nav>

        <div class="logout-section">
            <a href="{{ route('logout') }}" class="logout-btn" onclick="return confirm('Sign out?')">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sign Out
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-top">
                <div class="header-title">
                    <h1>Dashboard</h1>
                    <p class="header-subtitle">Welcome back, {{ Auth::user()->nama_pengguna }}</p>
                </div>
                <div class="header-badge">
                    {{ ucfirst(Auth::user()->role) }}
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-label">Total Reports</div>
                        <div class="stat-icon" style="background: #e3f2fd; color: #1976d2;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                    <div class="stat-caption">Your submissions</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-label">Pending</div>
                        <div class="stat-icon" style="background: #fff4e6; color: #e67700;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $stats['diajukan'] }}</div>
                    <div class="stat-caption">Awaiting review</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-label">In Progress</div>
                        <div class="stat-icon" style="background: #ede7f6; color: #5e35b1;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $stats['diproses'] }}</div>
                    <div class="stat-caption">Being handled</div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-label">Completed</div>
                        <div class="stat-icon" style="background: #e8f5e9; color: #2e7d32;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">{{ $stats['selesai'] }}</div>
                    <div class="stat-caption">Successfully resolved</div>
                </div>
            </div>

            <!-- Recent Reports Table -->
            <div class="table-section">
                <div class="table-header">
                    <h2>Recent Reports</h2>
                    <a href="{{ route('pengaduan.index') }}" class="view-all-btn">View All →</a>
                </div>
                
                @if($pengaduans->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Location</th>
                            <th>Item</th>
                            <th>Submitted</th>
                            <th>Status</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengaduans->take(10) as $pengaduan)
                        <tr>
                            <td><strong>#{{ $pengaduan->id }}</strong></td>
                            <td>{{ $pengaduan->lokasi }}</td>
                            <td>{{ $pengaduan->barang }}</td>
                            <td>{{ $pengaduan->created_at->format('d M Y, H:i') }} WIB</td>
                            <td>
                                <span class="status-badge {{ $pengaduan->status }}">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </td>
                            <td>
                                @if($pengaduan->catatan_petugas)
                                    {{ Str::limit($pengaduan->catatan_petugas, 50) }}
                                @else
                                    <span style="color: var(--text-tertiary);">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3>No Reports Yet</h3>
                    <p>You haven't submitted any facility reports. Click "Reports" to create your first submission.</p>
                </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
