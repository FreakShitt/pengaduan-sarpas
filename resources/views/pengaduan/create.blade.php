<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>New Report — Facility Management</title>
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
            max-width: 900px;
        }

        /* Form Card */
        .form-card {
            background: var(--bg-white);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 3rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            animation: slideIn 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            margin-bottom: 2.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .form-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .form-header p {
            color: var(--text-secondary);
            font-size: 0.9375rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 2rem;
            animation: fadeInUp 0.5s ease-out backwards;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group label {
            display: block;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            transition: color 0.3s;
        }

        .form-group:focus-within label {
            color: var(--accent);
        }

        .form-group label .required {
            color: #c62828;
            margin-left: 0.25rem;
            display: inline-block;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 0.9375rem;
            font-family: inherit;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--bg-white);
            color: var(--text-primary);
        }

        .form-control:hover {
            border-color: #d4d4d4;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(197, 151, 95, 0.12);
            transform: translateY(-1px);
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
            min-height: 140px;
            line-height: 1.6;
        }

        .help-text {
            font-size: 0.8125rem;
            color: var(--text-tertiary);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: color 0.3s;
        }

        .help-text::before {
            content: '💡';
            font-size: 1rem;
            opacity: 0.7;
        }

        .form-group:focus-within .help-text {
            color: var(--accent);
        }

        /* File Upload */
        .file-upload-area {
            position: relative;
            margin-top: 0.75rem;
        }

        .file-input {
            display: none;
        }

        .file-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            border: 2px dashed var(--border);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(135deg, #fafafa 0%, #ffffff 100%);
            position: relative;
            overflow: hidden;
        }

        .file-label::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(197, 151, 95, 0.1), transparent);
            transition: left 0.5s;
        }

        .file-label:hover::before {
            left: 100%;
        }

        .file-label:hover {
            border-color: var(--accent);
            background: linear-gradient(135deg, rgba(197, 151, 95, 0.05) 0%, rgba(197, 151, 95, 0.1) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(197, 151, 95, 0.15);
        }

        .file-label.has-file {
            border-color: #2e7d32;
            background: linear-gradient(135deg, rgba(46, 125, 50, 0.05) 0%, rgba(46, 125, 50, 0.1) 100%);
            border-style: solid;
        }

        .file-icon {
            width: 56px;
            height: 56px;
            color: var(--text-tertiary);
            margin-bottom: 1rem;
            transition: all 0.3s;
        }

        .file-label:hover .file-icon {
            transform: scale(1.1) rotate(5deg);
            color: var(--accent);
        }

        .file-label.has-file .file-icon {
            color: #2e7d32;
            animation: successPulse 0.6s ease-out;
        }

        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        .file-text {
            text-align: center;
        }

        .file-text p {
            margin: 0;
            color: var(--text-secondary);
            font-size: 0.9375rem;
        }

        .file-text strong {
            color: var(--text-primary);
        }

        .file-name {
            font-weight: 600;
            color: #2e7d32;
            margin-top: 0.75rem;
            font-size: 0.875rem;
        }

        .image-preview {
            margin-top: 1.5rem;
            display: none;
            text-align: center;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        /* Alert */
        .alert {
            padding: 1.25rem 1.75rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .alert-error {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }

        .alert ul {
            margin: 0.5rem 0 0 1.5rem;
            padding: 0;
        }

        .alert li {
            margin: 0.25rem 0;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
        }

        .btn {
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 12px;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            text-decoration: none;
            letter-spacing: 0.02em;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn svg {
            position: relative;
            z-index: 1;
            transition: transform 0.3s;
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        .btn-primary {
            background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%);
            color: white;
            flex: 1;
            box-shadow: 0 4px 12px rgba(197, 151, 95, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(197, 151, 95, 0.4);
        }

        .btn-primary:hover svg {
            transform: scale(1.1) rotate(5deg);
        }

        .btn-primary:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(197, 151, 95, 0.3);
        }

        .btn-secondary {
            background: white;
            color: var(--text-primary);
            border: 2px solid var(--border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .btn-secondary:hover {
            background: var(--bg-light);
            border-color: var(--text-tertiary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .btn-secondary:hover svg {
            transform: rotate(-5deg);
        }

        .btn-secondary:active {
            transform: translateY(0);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spinner 0.8s linear infinite;
        }

        @keyframes spinner {
            to { transform: rotate(360deg); }
        }

        /* Error Messages */
        .error-message {
            color: #c62828;
            font-size: 0.8125rem;
            margin-top: 0.5rem;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        /* Responsive */
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

            .form-card {
                padding: 2rem 1.5rem;
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
            <div class="header-title">
                <h1>Create New Report</h1>
                <p class="header-subtitle">Report facility damage or malfunction</p>
            </div>
        </header>

        <!-- Content Area -->
        <div class="content-area">
            <div class="form-card">
                <div class="form-header">
                    <h2>Report Details</h2>
                    <p>Please provide clear and accurate information about the issue</p>
                </div>

                @if($errors->any())
                <div class="alert alert-error">
                    <strong>Error!</strong> Please check the following:
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" id="pengaduanForm">
                    @csrf

                    <!-- Location -->
                    <div class="form-group">
                        <label for="lokasi">
                            Location <span class="required">*</span>
                        </label>
                        <select name="lokasi" id="lokasi" class="form-control" required>
                            <option value="">— Select Location —</option>
                            @foreach($lokasi as $lok)
                            <option value="{{ $lok }}" {{ old('lokasi') == $lok ? 'selected' : '' }}>{{ $lok }}</option>
                            @endforeach
                        </select>
                        <p class="help-text">Select the location where the damage occurred</p>
                        <span class="error-message" id="lokasiError"></span>
                    </div>

                    <!-- Item -->
                    <div class="form-group">
                        <label for="barang">
                            Item / Facility <span class="required">*</span>
                        </label>
                        <select name="barang" id="barang" class="form-control" required disabled>
                            <option value="">— Select Location First —</option>
                        </select>
                        <p class="help-text">Select the damaged item or facility</p>
                        <span class="error-message" id="barangError"></span>
                        
                        <!-- Option untuk item tidak ada di list -->
                        <div style="margin-top: 1rem; padding: 1rem; background: rgba(197, 151, 95, 0.05); border: 1px solid rgba(197, 151, 95, 0.2); border-radius: 8px;">
                            <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer; margin: 0;">
                                <input type="checkbox" id="useTemporaryItem" style="width: 18px; height: 18px; cursor: pointer;">
                                <span style="font-size: 0.875rem; font-weight: 500; color: #1a1a1a;">Item tidak ada di daftar? Ajukan item baru</span>
                            </label>
                        </div>

                        <!-- Input temporary item (hidden by default) -->
                        <div id="temporaryItemSection" style="display: none; margin-top: 1rem; padding: 1rem; background: #fffbf5; border: 2px dashed #c5975f; border-radius: 8px;">
                            <label for="temporary_item_name" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; color: #1a1a1a;">
                                Nama Item Baru <span style="color: #c62828;">*</span>
                            </label>
                            <input type="text" id="temporary_item_name" name="temporary_item_name" class="form-control" placeholder="Contoh: Proyektor Ruang 301" style="margin-bottom: 0.75rem;">
                            <label for="temporary_item_desc" style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem; color: #1a1a1a;">
                                Deskripsi Item (Opsional)
                            </label>
                            <textarea id="temporary_item_desc" name="temporary_item_desc" class="form-control" placeholder="Deskripsi singkat tentang item ini..." rows="2"></textarea>
                            <p style="font-size: 0.8125rem; color: #c5975f; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Admin akan meninjau dan menyetujui item baru ini
                            </p>
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="form-group">
                        <label for="detail_laporan">
                            Report Details <span class="required">*</span>
                        </label>
                        <textarea name="detail_laporan" id="detail_laporan" class="form-control" required placeholder="Describe the condition in detail...">{{ old('detail_laporan') }}</textarea>
                        <p class="help-text">Minimum 10 characters. Explain the damage condition, impact, and urgency</p>
                        <span class="error-message" id="detailError"></span>
                    </div>

                    <!-- Photo Upload -->
                    <div class="form-group">
                        <label for="gambar">Photo Evidence</label>
                        <div class="file-upload-area">
                            <input type="file" name="gambar" id="gambar" class="file-input" accept="image/*">
                            <label for="gambar" class="file-label" id="fileLabel">
                                <svg class="file-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div class="file-text">
                                    <p><strong>Click to upload photo</strong></p>
                                    <p>or drag and drop</p>
                                    <p style="margin-top: 0.5rem; color: var(--text-tertiary);">JPG, PNG (Max. 2MB)</p>
                                    <p class="file-name" id="fileName"></p>
                                </div>
                            </label>
                        </div>
                        <div class="image-preview" id="imagePreview">
                            <img id="previewImg" src="" alt="Preview">
                        </div>
                        <p class="help-text">Upload photo evidence to assist verification (optional)</p>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            <span>Kembali</span>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Kirim Laporan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const lokasiSelect = document.getElementById('lokasi');
            const barangSelect = document.getElementById('barang');
            const gambarInput = document.getElementById('gambar');
            const fileLabel = document.getElementById('fileLabel');
            const fileName = document.getElementById('fileName');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const useTemporaryItemCheckbox = document.getElementById('useTemporaryItem');
            const temporaryItemSection = document.getElementById('temporaryItemSection');
            const temporaryItemName = document.getElementById('temporary_item_name');

            // Toggle temporary item section
            useTemporaryItemCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    temporaryItemSection.style.display = 'block';
                    barangSelect.required = false;
                    barangSelect.disabled = true;
                    temporaryItemName.required = true;
                } else {
                    temporaryItemSection.style.display = 'none';
                    barangSelect.required = true;
                    barangSelect.disabled = !lokasiSelect.value;
                    temporaryItemName.required = false;
                }
            });

            // Load items based on location
            lokasiSelect.addEventListener('change', function() {
                const lokasi = this.value;
                
                if (lokasi) {
                    barangSelect.innerHTML = '<option value="">Loading...</option>';
                    barangSelect.disabled = true;

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    fetch(`/pengaduan/get-barang?lokasi=${encodeURIComponent(lokasi)}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        barangSelect.innerHTML = '<option value="">— Select Item/Facility —</option>';
                        
                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(barang => {
                                barangSelect.innerHTML += `<option value="${barang}">${barang}</option>`;
                            });
                            barangSelect.disabled = false;
                        } else {
                            barangSelect.innerHTML = '<option value="">No items available</option>';
                            barangSelect.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        barangSelect.innerHTML = '<option value="">— Select Location First —</option>';
                        barangSelect.disabled = true;
                        alert('Failed to load items: ' + error.message);
                    });
                } else {
                    barangSelect.innerHTML = '<option value="">— Select Location First —</option>';
                    barangSelect.disabled = true;
                }
            });

            // Photo preview
            gambarInput.addEventListener('change', function() {
                const file = this.files[0];
                
                if (file) {
                    // Validate file size (max 2MB)
                    if (file.size > 2048 * 1024) {
                        alert('File size too large! Maximum 2MB');
                        this.value = '';
                        return;
                    }

                    // Validate file type
                    if (!file.type.match('image.*')) {
                        alert('File must be an image!');
                        this.value = '';
                        return;
                    }

                    // Update label
                    fileName.textContent = file.name;
                    fileLabel.classList.add('has-file');

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    fileName.textContent = '';
                    fileLabel.classList.remove('has-file');
                    imagePreview.style.display = 'none';
                }
            });

            // Form validation and submit
            const form = document.getElementById('pengaduanForm');
            const submitBtn = form.querySelector('.btn-primary');
            
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Validate location
                if (!lokasiSelect.value) {
                    document.getElementById('lokasiError').textContent = 'Lokasi wajib dipilih';
                    document.getElementById('lokasiError').classList.add('show');
                    isValid = false;
                } else {
                    document.getElementById('lokasiError').classList.remove('show');
                }

                // Validate item (barang or temporary item)
                if (useTemporaryItemCheckbox.checked) {
                    // Validate temporary item
                    if (!temporaryItemName.value.trim()) {
                        document.getElementById('barangError').textContent = 'Nama item baru wajib diisi';
                        document.getElementById('barangError').classList.add('show');
                        isValid = false;
                    } else {
                        document.getElementById('barangError').classList.remove('show');
                    }
                } else {
                    // Validate regular item
                    if (!barangSelect.value) {
                        document.getElementById('barangError').textContent = 'Barang/Fasilitas wajib dipilih';
                        document.getElementById('barangError').classList.add('show');
                        isValid = false;
                    } else {
                        document.getElementById('barangError').classList.remove('show');
                    }
                }

                // Validate details
                const detail = document.getElementById('detail_laporan').value;
                if (detail.length < 10) {
                    document.getElementById('detailError').textContent = 'Detail minimal 10 karakter';
                    document.getElementById('detailError').classList.add('show');
                    isValid = false;
                } else {
                    document.getElementById('detailError').classList.remove('show');
                }

                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first error
                    const firstError = document.querySelector('.error-message.show');
                    if (firstError) {
                        firstError.parentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                } else {
                    // Add loading state
                    submitBtn.disabled = true;
                    submitBtn.classList.add('btn-loading');
                    const btnText = submitBtn.querySelector('span');
                    const btnIcon = submitBtn.querySelector('svg');
                    if (btnText) btnText.style.opacity = '0';
                    if (btnIcon) btnIcon.style.opacity = '0';
                }
            });
        });
    </script>
</body>
</html>
