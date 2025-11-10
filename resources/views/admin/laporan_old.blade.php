<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%); min-height: 100vh; }
        .dashboard-container { display: flex; min-height: 100vh; }
        .sidebar { width: 280px; background: linear-gradient(180deg, #1a1a1a 0%, #2d2d2d 100%); color: white; padding: 2rem 0; position: fixed; height: 100vh; left: 0; top: 0; overflow-y: auto; box-shadow: 4px 0 24px rgba(0, 0, 0, 0.1); }
        .sidebar-header { padding: 0 2rem 2rem; border-bottom: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 2rem; }
        .sidebar-title { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; color: #c5975f; }
        .sidebar-subtitle { font-size: 0.875rem; color: rgba(255, 255, 255, 0.6); font-weight: 300; }
        .nav-menu { list-style: none; padding: 0 1rem; }
        .nav-item { margin-bottom: 0.5rem; }
        .nav-link { display: flex; align-items: center; padding: 1rem 1.5rem; color: rgba(255, 255, 255, 0.7); text-decoration: none; border-radius: 12px; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); font-weight: 500; }
        .nav-link:hover { background: rgba(197, 151, 95, 0.1); color: #c5975f; transform: translateX(5px); }
        .nav-link.active { background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; }
        .nav-icon { width: 20px; height: 20px; margin-right: 1rem; }
        .badge-notification { background: #ef4444; color: white; font-size: 0.7rem; padding: 0.2rem 0.5rem; border-radius: 10px; margin-left: 0.5rem; font-weight: 600; animation: pulse 2s ease-in-out infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }
        .main-content { margin-left: 280px; flex: 1; padding: 2rem; }
        .page-header { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); margin-bottom: 2rem; }
        .header-top { display: flex; justify-content: space-between; align-items: center; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: #1a1a1a; }
        .logout-btn { background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .logout-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(197, 151, 95, 0.3); }
        .filter-section { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); margin-bottom: 2rem; }
        .filter-form { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end; }
        .form-group { display: flex; flex-direction: column; }
        .form-label { margin-bottom: 0.5rem; font-weight: 600; color: #1a1a1a; font-size: 0.875rem; }
        .form-control { padding: 0.75rem; border: 2px solid #e8e8e8; border-radius: 8px; font-size: 0.875rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .form-control:focus { outline: none; border-color: #c5975f; box-shadow: 0 0 0 3px rgba(197, 151, 95, 0.1); }
        .btn-filter { background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.75rem 2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .btn-filter:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(197, 151, 95, 0.3); }
        .btn-export { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; font-size: 0.875rem; text-decoration: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); border: 2px solid transparent; }
        .btn-export svg { width: 18px; height: 18px; }
        .btn-export-pdf { background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); color: white; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25); }
        .btn-export-pdf:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(220, 38, 38, 0.4); }
        .btn-export-doc { background: white; color: #2563eb; border-color: #2563eb; }
        .btn-export-doc:hover { background: #2563eb; color: white; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3); }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card { background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); border: 1px solid #e8e8e8; }
        .stat-label { font-size: 0.875rem; color: #666; margin-bottom: 0.5rem; font-weight: 500; }
        .stat-value { font-size: 2rem; font-weight: 700; color: #1a1a1a; font-family: 'Playfair Display', serif; }
        .content-section { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); }
        .data-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .data-table thead { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); color: white; }
        .data-table th { padding: 1rem; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .data-table th:first-child { border-top-left-radius: 12px; }
        .data-table th:last-child { border-top-right-radius: 12px; }
        .data-table tbody tr { border-bottom: 1px solid #e8e8e8; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .data-table tbody tr:hover { background: #f5f5f5; }
        .data-table td { padding: 1rem; color: #333; font-size: 0.875rem; }
        .status-badge { display: inline-block; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-pending { background: #FEF3C7; color: #92400E; }
        .status-proses { background: #DBEAFE; color: #1E40AF; }
        .status-selesai { background: #D1FAE5; color: #065F46; }
        .status-ditolak { background: #FEE2E2; color: #991B1B; }
        .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem; }
        .pagination a, .pagination span { padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; color: #333; background: #f5f5f5; transition: all 0.3s; }
        .pagination a:hover { background: #c5975f; color: white; }
        .pagination .active { background: #c5975f; color: white; }
        .empty-state { text-align: center; padding: 3rem; color: #999; }
        .empty-state-icon { font-size: 4rem; margin-bottom: 1rem; opacity: 0.3; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="sidebar-title">Admin Panel</h1>
                <p class="sidebar-subtitle">Sistem Pengaduan Sarpras</p>
            </div>
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link"><svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>Dashboard</a></li>
                    <li class="nav-item"><a href="{{ route('admin.petugas') }}" class="nav-link"><svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>Kelola Petugas</a></li>
                    <li class="nav-item"><a href="{{ route('admin.users') }}" class="nav-link"><svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>Kelola Pengguna</a></li>
                    <li class="nav-item"><a href="{{ route('admin.lokasi') }}" class="nav-link"><svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Kelola Lokasi</a></li>
                    <li class="nav-item"><a href="{{ route('admin.barang') }}" class="nav-link"><svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>Kelola Barang</a></li>
                    <li class="nav-item"><a href="{{ route('admin.item-requests') }}" class="nav-link"><svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>Permintaan Item Baru@php $pendingCount = \App\Models\ItemRequest::where('status', 'pending')->count(); @endphp @if($pendingCount > 0)<span class="badge-notification">{{ $pendingCount }}</span>@endif</a></li>
                    <li class="nav-item"><a href="{{ route('admin.laporan') }}" class="nav-link active"><svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Laporan</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <div class="header-top">
                    <h1 class="page-title">Laporan Pengaduan</h1>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>

            <div class="filter-section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 600; color: #1a1a1a; margin: 0;">Filter & Export</h3>
                    <div style="display: flex; gap: 0.75rem;">
                        <a href="{{ route('admin.laporan.export-pdf', request()->all()) }}" target="_blank" class="btn-export btn-export-pdf">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Export PDF
                        </a>
                        <a href="{{ route('admin.laporan.export-doc', request()->all()) }}" class="btn-export btn-export-doc">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export DOC
                        </a>
                    </div>
                </div>
                <form action="{{ route('admin.laporan') }}" method="GET" class="filter-form">
                    <div class="form-group">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lokasi" class="form-label">Lokasi</label>
                        <select id="lokasi" name="lokasi" class="form-control">
                            <option value="">Semua Lokasi</option>
                            @foreach($lokasiList as $lok)
                                <option value="{{ $lok->nama_lokasi }}" {{ request('lokasi') == $lok->nama_lokasi ? 'selected' : '' }}>
                                    {{ $lok->nama_lokasi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-filter">Filter</button>
                    </div>
                </form>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Total Laporan</div>
                    <div class="stat-value">{{ $stats['total'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Diajukan</div>
                    <div class="stat-value">{{ $stats['diajukan'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Diproses</div>
                    <div class="stat-value">{{ $stats['diproses'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Selesai</div>
                    <div class="stat-value">{{ $stats['selesai'] }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Ditolak</div>
                    <div class="stat-value">{{ $stats['ditolak'] }}</div>
                </div>
            </div>

            <div class="content-section">
                @if($laporan->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelapor</th>
                                <th>Lokasi</th>
                                <th>Barang</th>
                                <th>Detail</th>
                                <th>Status</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($laporan as $l)
                            <tr>
                                <td>{{ $l->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $l->user->nama_pengguna }}</td>
                                <td>{{ $l->lokasi }}</td>
                                <td>{{ $l->barang }}</td>
                                <td>{{ Str::limit($l->detail_laporan, 50) }}</td>
                                <td>
                                    @if($l->status === 'diajukan')
                                        <span class="status-badge status-pending">Diajukan</span>
                                    @elseif($l->status === 'diproses')
                                        <span class="status-badge status-proses">Diproses</span>
                                    @elseif($l->status === 'selesai')
                                        <span class="status-badge status-selesai">Selesai</span>
                                    @elseif($l->status === 'ditolak')
                                        <span class="status-badge status-ditolak">Ditolak</span>
                                    @else
                                        <span class="status-badge">{{ ucfirst($l->status ?? 'N/A') }}</span>
                                    @endif
                                </td>
                                <td>{{ $l->petugas ? $l->petugas->nama_pengguna : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $laporan->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <p>Tidak ada laporan ditemukan</p>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
