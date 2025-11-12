<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Technician Dashboard — Facility Management</title>
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

        /* Content Area */
        .content-area {
            padding: 3rem;
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
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .stat-card.total::before { background: #3b82f6; }
        .stat-card.pending::before { background: #e67700; }
        .stat-card.process::before { background: #5e35b1; }
        .stat-card.done::before { background: #2e7d32; }
        .stat-card.rejected::before { background: #c62828; }

        .stat-card:hover {
            background: linear-gradient(180deg, #ffffff 0%, #fafaf8 100%);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        @media (max-width: 1200px) {
            .stats-grid {
                flex-wrap: wrap;
            }
            .stat-card {
                min-width: 150px;
                border-right: 1px solid #e8e8e8;
                border-bottom: 1px solid #e8e8e8;
            }
            .stat-card:nth-child(3n) {
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

        /* Filter Section */
        .filter-card {
            background: var(--bg-white);
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .filter-header {
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            align-items: end;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.9375rem;
            font-family: inherit;
            transition: all 0.3s;
            background: var(--bg-white);
            color: var(--text-primary);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(197, 151, 95, 0.1);
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%23666666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1.25rem center;
            padding-right: 3rem;
        }

        .btn {
            padding: 0.875rem 1.75rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
            border: none;
            letter-spacing: 0.02em;
        }

        .btn-primary {
            background: var(--accent);
            color: white;
        }

        .btn-primary:hover {
            background: #b08550;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(197, 151, 95, 0.3);
        }

        .btn-secondary {
            background: var(--bg-light);
            color: var(--text-primary);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--border);
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
        }

        .table-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.02em;
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

        .btn-action {
            background: var(--accent);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-action:hover {
            background: #b08550;
        }

        .pagination {
            display: flex;
            justify-content: center;
            padding: 2rem;
            gap: 0.5rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.625rem 1rem;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.875rem;
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.3s;
        }

        .pagination a:hover {
            background: var(--bg-light);
        }

        .pagination .active {
            background: var(--accent);
            color: white;
            border-color: var(--accent);
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

            table {
                font-size: 0.875rem;
            }

            th, td {
                padding: 0.75rem 1rem;
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
                <div class="user-role">Technician</div>
            </div>
        </div>

        <nav class="nav-menu">
            <a href="{{ route('petugas.dashboard') }}" class="nav-item active">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
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
            <div class="header-title">
                <h1>Technician Dashboard</h1>
                <p class="header-subtitle">Manage and monitor all facility reports</p>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Statistics Bar -->
            <div class="stats-bar">
                <div class="stats-grid">
                    <div class="stat-card total">
                        <div class="stat-label">Total Reports</div>
                        <div class="stat-value">{{ $stats['total'] }}</div>
                        <div class="stat-change">All reports</div>
                    </div>
                    <div class="stat-card pending">
                        <div class="stat-label">Pending</div>
                        <div class="stat-value">{{ $stats['diajukan'] }}</div>
                        <div class="stat-change">Waiting</div>
                    </div>
                    <div class="stat-card process">
                        <div class="stat-label">In Progress</div>
                        <div class="stat-value">{{ $stats['diproses'] }}</div>
                        <div class="stat-change">Processing</div>
                    </div>
                    <div class="stat-card done">
                        <div class="stat-label">Completed</div>
                        <div class="stat-value">{{ $stats['selesai'] }}</div>
                        <div class="stat-change">Done</div>
                    </div>
                    <div class="stat-card rejected">
                        <div class="stat-label">Rejected</div>
                        <div class="stat-value">{{ $stats['ditolak'] }}</div>
                        <div class="stat-change">Declined</div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="filter-card">
                <h3 class="filter-header">Filter Reports</h3>
                <form action="{{ route('petugas.dashboard') }}" method="GET" class="filter-form">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>In Progress</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Completed</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Location, item..." value="{{ request('search') }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Apply Filter</button>
                    </div>
                    @if(request('status') || request('search'))
                    <div class="form-group">
                        <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary">Reset</a>
                    </div>
                    @endif
                </form>
            </div>

            <!-- Reports Table -->
            <div class="table-section">
                <div class="table-header">
                    <h2>All Reports</h2>
                </div>
                
                @if($pengaduans->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Reporter</th>
                            <th>Location</th>
                            <th>Item</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengaduans as $index => $pengaduan)
                        <tr>
                            <td><strong>{{ $pengaduans->firstItem() + $index }}</strong></td>
                            <td>
                                <strong>{{ $pengaduan->user->nama_pengguna }}</strong><br>
                                <small style="color: var(--text-tertiary);">{{ ucfirst($pengaduan->user->role) }}</small>
                            </td>
                            <td>{{ $pengaduan->lokasi }}</td>
                            <td>{{ $pengaduan->barang }}</td>
                            <td>{{ $pengaduan->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <span class="status-badge {{ $pengaduan->status }}">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('petugas.detail', $pengaduan->id) }}" class="btn-action">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Pagination -->
                <div class="pagination">
                    {{ $pengaduans->links() }}
                </div>
                @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3>No Reports Found</h3>
                    <p>No reports match your filter criteria</p>
                </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
