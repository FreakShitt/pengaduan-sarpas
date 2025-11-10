<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports — Facility Management</title>
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

        /* Sidebar - sama dengan dashboard */
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

        .btn-create {
            background: var(--accent);
            color: white;
            padding: 0.875rem 1.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            letter-spacing: 0.02em;
        }

        .btn-create:hover {
            background: #b08550;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(197, 151, 95, 0.3);
        }

        /* Content Area */
        .content-area {
            padding: 3rem;
        }

        .alert {
            padding: 1.25rem 1.75rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        /* Report Cards Grid */
        .reports-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2rem;
        }

        .report-card {
            background: var(--bg-white);
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .report-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .card-content {
            padding: 2rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .card-id {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--text-primary);
            font-size: 1.125rem;
            letter-spacing: -0.02em;
        }

        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 500;
            letter-spacing: 0.02em;
            text-transform: uppercase;
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

        .card-location {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-item {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .card-description {
            color: var(--text-secondary);
            font-size: 0.9375rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

        .card-date {
            font-size: 0.8125rem;
            color: var(--text-tertiary);
            font-weight: 400;
        }

        .btn-view {
            background: var(--bg-light);
            color: var(--text-primary);
            padding: 0.625rem 1.25rem;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
            border: 1px solid var(--border);
        }

        .btn-view:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 6rem 2rem;
            background: var(--bg-white);
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        .empty-state svg {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            color: var(--text-tertiary);
            opacity: 0.3;
        }

        .empty-state h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 0.75rem;
        }

        .empty-state p {
            font-size: 0.9375rem;
            color: var(--text-tertiary);
            margin-bottom: 2rem;
        }

        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .reports-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .content-area {
                padding: 2rem 1.5rem;
            }

            .header {
                padding: 1.5rem;
            }

            .reports-grid {
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
            <a href="{{ route('dashboard') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('pengaduan.index') }}" class="nav-item active">
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
                    <h1>My Reports</h1>
                    <p class="header-subtitle">Manage and track your facility reports</p>
                </div>
                <a href="{{ route('pengaduan.create') }}" class="btn-create">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Report
                </a>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            @if(session('success'))
            <div class="alert alert-success">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            </div>
            @endif

            @if($pengaduans->count() > 0)
            <div class="reports-grid">
                @foreach($pengaduans as $pengaduan)
                <div class="report-card">
                    <div class="card-content">
                        <div class="card-header">
                            <span class="card-id">#{{ str_pad($pengaduan->id, 4, '0', STR_PAD_LEFT) }}</span>
                            <span class="status-badge {{ $pengaduan->status }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                        </div>
                        
                        <div class="card-location">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $pengaduan->lokasi }}
                        </div>
                        
                        <div class="card-item">{{ $pengaduan->barang }}</div>
                        
                        <div class="card-description">{{ $pengaduan->detail_laporan }}</div>
                        
                        <div class="card-footer">
                            <div class="card-date">
                                {{ $pengaduan->created_at->format('d M Y, H:i') }} WIB
                            </div>
                            <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="btn-view">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3>No Reports Yet</h3>
                <p>You haven't submitted any facility reports yet. Create your first report to get started.</p>
                <a href="{{ route('pengaduan.create') }}" class="btn-create">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create First Report
                </a>
            </div>
            @endif
        </div>
    </main>
</body>
</html>
