<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Report Details — Facility Management</title>
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

        .breadcrumb {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            margin-top: 1rem;
            font-size: 0.875rem;
        }

        .breadcrumb a {
            color: var(--accent);
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumb a:hover {
            color: var(--primary);
        }

        .breadcrumb span {
            color: var(--text-tertiary);
        }

        /* Content Area */
        .content-area {
            padding: 3rem;
            max-width: 1400px;
        }

        /* Alert */
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

        /* Detail Grid */
        .detail-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .card {
            background: var(--bg-white);
            border-radius: 12px;
            border: 1px solid var(--border);
            overflow: hidden;
        }

        .card-header {
            padding: 2rem;
            border-bottom: 1px solid var(--border);
            background: var(--bg-light);
        }

        .card-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            letter-spacing: -0.02em;
        }

        .card-body {
            padding: 2rem;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 160px 1fr;
            gap: 1.5rem;
            padding: 1.25rem 0;
            border-bottom: 1px solid var(--bg-light);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .detail-value {
            color: var(--text-primary);
            font-size: 0.9375rem;
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

        .image-container {
            margin-top: 0.75rem;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .image-preview {
            width: 100%;
            max-width: 500px;
            display: block;
        }

        .no-image {
            padding: 3rem 2rem;
            background: var(--bg-light);
            border-radius: 8px;
            text-align: center;
            color: var(--text-tertiary);
            font-size: 0.875rem;
        }

        .notes-box {
            background: #fff4e6;
            padding: 1.25rem;
            border-radius: 8px;
            border-left: 4px solid #e67700;
            margin-top: 0.75rem;
        }

        /* Form */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .form-group label .required {
            color: #c62828;
            margin-left: 0.25rem;
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

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            line-height: 1.6;
        }

        .help-text {
            font-size: 0.8125rem;
            color: var(--text-tertiary);
            margin-top: 0.5rem;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
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
            flex: 1;
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

            .card-body {
                padding: 1.5rem;
            }

            .detail-row {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .form-actions {
                flex-direction: column;
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
                <h1>Report Details</h1>
                <p class="header-subtitle">Review and update report status</p>
            </div>
            <div class="breadcrumb">
                <a href="{{ route('petugas.dashboard') }}">Dashboard</a>
                <span>›</span>
                <span>Report #{{ $pengaduan->id }}</span>
            </div>
        </header>

        <!-- Content -->
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

            <div class="detail-grid">
                <!-- Report Details -->
                <div class="card">
                    <div class="card-header">
                        <h2>Report Information</h2>
                    </div>
                    <div class="card-body">
                        <div class="detail-row">
                            <div class="detail-label">Report ID</div>
                            <div class="detail-value"><strong>#{{ str_pad($pengaduan->id, 4, '0', STR_PAD_LEFT) }}</strong></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Reporter</div>
                            <div class="detail-value">
                                <strong>{{ $pengaduan->user->nama_pengguna }}</strong><br>
                                <small style="color: var(--text-tertiary);">{{ ucfirst($pengaduan->user->role) }} • {{ $pengaduan->user->username }}</small>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Location</div>
                            <div class="detail-value">{{ $pengaduan->lokasi }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Item/Facility</div>
                            <div class="detail-value">{{ $pengaduan->barang }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Report Date</div>
                            <div class="detail-value">{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Status</div>
                            <div class="detail-value">
                                <span class="status-badge {{ $pengaduan->status }}">
                                    {{ ucfirst($pengaduan->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Description</div>
                            <div class="detail-value">{{ $pengaduan->detail_laporan }}</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Photo Evidence</div>
                            <div class="detail-value">
                                @if($pengaduan->gambar)
                                    <div class="image-container">
                                        <img src="{{ asset('uploads/pengaduan/' . $pengaduan->gambar) }}" alt="Damage Photo" class="image-preview">
                                    </div>
                                @else
                                    <div class="no-image">No photo provided</div>
                                @endif
                            </div>
                        </div>
                        @if($pengaduan->catatan_petugas)
                        <div class="detail-row">
                            <div class="detail-label">Technician Notes</div>
                            <div class="detail-value">
                                <div class="notes-box">
                                    {{ $pengaduan->catatan_petugas }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="card">
                    <div class="card-header">
                        <h2>Update Status</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('petugas.update-status', $pengaduan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="status">
                                    Report Status <span class="required">*</span>
                                </label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="diajukan" {{ $pengaduan->status == 'diajukan' ? 'selected' : '' }}>Pending</option>
                                    <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>In Progress</option>
                                    <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Completed</option>
                                    <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <p class="help-text">Select the current status of this report</p>
                            </div>

                            <div class="form-group">
                                <label for="catatan_petugas">Technician Notes</label>
                                <textarea name="catatan_petugas" id="catatan_petugas" class="form-control" placeholder="Add notes for the reporter (optional)">{{ $pengaduan->catatan_petugas }}</textarea>
                                <p class="help-text">Explain the actions taken or planned (max 500 characters)</p>
                            </div>

                            <div class="form-actions">
                                <a href="{{ route('petugas.dashboard') }}" class="btn btn-secondary">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
