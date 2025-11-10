<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lokasi - Admin</title>
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
        .main-content { margin-left: 280px; flex: 1; padding: 2rem; }
        .page-header { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); margin-bottom: 2rem; }
        .header-top { display: flex; justify-content: space-between; align-items: center; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: #1a1a1a; }
        .logout-btn { background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .logout-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(197, 151, 95, 0.3); }
        .content-section { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08); }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a1a1a; }
        .form-control { width: 100%; padding: 0.875rem 1rem; border: 2px solid #e8e8e8; border-radius: 8px; font-size: 1rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); font-family: 'Inter', sans-serif; }
        .form-control:focus { outline: none; border-color: #c5975f; box-shadow: 0 0 0 3px rgba(197, 151, 95, 0.1); }
        textarea.form-control { resize: vertical; min-height: 100px; }
        .checkbox-wrapper { display: flex; align-items: center; gap: 0.75rem; }
        .checkbox-input { width: 20px; height: 20px; cursor: pointer; }
        .error-message { color: #dc2626; font-size: 0.875rem; margin-top: 0.5rem; }
        .form-actions { display: flex; gap: 1rem; margin-top: 2rem; }
        .btn-primary { background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.875rem 2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 16px rgba(197, 151, 95, 0.3); }
        .btn-secondary { background: #f5f5f5; color: #333; padding: 0.875rem 2rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); text-decoration: none; display: inline-block; }
        .btn-secondary:hover { background: #e8e8e8; }
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
                    <li class="nav-item"><a href="{{ route('admin.lokasi') }}" class="nav-link active"><svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>Kelola Lokasi</a></li>
                    <li class="nav-item"><a href="{{ route('admin.barang') }}" class="nav-link"><svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>Kelola Barang</a></li>
                    <li class="nav-item"><a href="{{ route('admin.laporan') }}" class="nav-link"><svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Laporan</a></li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <div class="header-top">
                    <h1 class="page-title">Edit Lokasi</h1>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>

            <div class="content-section">
                <form action="{{ route('admin.lokasi.update', $lokasi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                        <input type="text" id="nama_lokasi" name="nama_lokasi" class="form-control" 
                               value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}" required>
                        @error('nama_lokasi')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                        <textarea id="deskripsi" name="deskripsi" class="form-control">{{ old('deskripsi', $lokasi->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="aktif" name="aktif" class="checkbox-input" value="1" 
                                   {{ old('aktif', $lokasi->aktif) ? 'checked' : '' }}>
                            <label for="aktif" class="form-label" style="margin-bottom: 0;">Status Aktif</label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary">Update</button>
                        <a href="{{ route('admin.lokasi') }}" class="btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
