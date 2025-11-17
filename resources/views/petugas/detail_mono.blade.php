<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan #{{ $pengaduan->id }} — Petugas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    <header class="mono-header">
        <div class="mono-container">
            <nav class="mono-nav">
                <div class="mono-logo">SARPAS / PETUGAS</div>
                <ul class="mono-nav-links">
                    <li><a href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('petugas.dashboard') }}?status=diajukan">Diajukan</a></li>
                    <li><a href="{{ route('petugas.dashboard') }}?status=diproses">Diproses</a></li>
                </ul>
                <div style="display: flex; align-items: center; gap: 2rem;">
                    <div style="text-align: right;">
                        <div style="font-size: 0.875rem; font-weight: 600;">{{ Auth::user()->nama_pengguna }}</div>
                        <div style="font-size: 0.75rem; color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.05em;">Petugas</div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="mono-btn mono-btn-sm">Logout</button>
                    </form>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="mono-section" style="padding: 6rem 0 4rem; border-bottom: 2px solid black;">
            <div class="mono-container">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <h6 style="color: var(--color-gray-600); margin-bottom: 1rem;">Laporan #{{ $pengaduan->id }}</h6>
                        <h1 style="font-size: 3rem; margin-bottom: 1rem;">{{ $pengaduan->lokasi }}</h1>
                        <p style="font-size: 1.5rem; color: var(--color-gray-600);">
                            {{ $pengaduan->barang }}
                        </p>
                    </div>
                    <div style="text-align: right;">
                        @if($pengaduan->status == 'diajukan')
                            <span class="mono-badge" style="font-size: 1rem; padding: 0.5rem 1rem;">{{ ucfirst($pengaduan->status) }}</span>
                        @elseif($pengaduan->status == 'diproses')
                            <span class="mono-badge" style="font-size: 1rem; padding: 0.5rem 1rem;">{{ ucfirst($pengaduan->status) }}</span>
                        @elseif($pengaduan->status == 'selesai')
                            <span class="mono-badge mono-badge-filled" style="font-size: 1rem; padding: 0.5rem 1rem;">{{ ucfirst($pengaduan->status) }}</span>
                        @else
                            <span class="mono-badge mono-badge-outlined" style="font-size: 1rem; padding: 0.5rem 1rem;">{{ ucfirst($pengaduan->status) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Success Alert -->
        @if (session('success'))
        <section style="background: var(--color-gray-50); padding: 1.5rem 0; border-bottom: 1px solid var(--color-gray-200);">
            <div class="mono-container">
                <div class="mono-alert mono-alert-success">
                    {{ session('success') }}
                </div>
            </div>
        </section>
        @endif

        <!-- Detail & Update Section -->
        <section class="mono-section">
            <div class="mono-container">
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 3rem;">
                    <!-- Left Column - Detail -->
                    <div style="display: grid; gap: 3rem;">
                        <!-- Meta Info -->
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; padding: 2rem; border: 1px solid var(--color-gray-200);">
                            <div>
                                <div style="font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-gray-600);">
                                    Pelapor
                                </div>
                                <div style="font-size: 1.125rem; font-weight: 600;">
                                    {{ $pengaduan->user ? $pengaduan->user->nama_pengguna : 'N/A' }}
                                </div>
                                <div style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 0.25rem;">
                                    {{ $pengaduan->user ? ucfirst($pengaduan->user->role) : '' }}
                                </div>
                            </div>
                            <div>
                                <div style="font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-gray-600);">
                                    Tanggal Lapor
                                </div>
                                <div style="font-size: 1.125rem; font-weight: 600;">
                                    {{ $pengaduan->created_at->format('d M Y') }}
                                </div>
                                <div style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 0.25rem;">
                                    {{ $pengaduan->created_at->format('H:i') }} WIB
                                </div>
                            </div>
                            <div>
                                <div style="font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-gray-600);">
                                    Jenis Barang
                                </div>
                                <div style="font-size: 1.125rem; font-weight: 600;">
                                    @if($pengaduan->is_temporary_item)
                                        <span class="mono-badge mono-badge-outlined">Barang Baru</span>
                                    @else
                                        Terdaftar
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div style="font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-gray-600);">
                                    Last Update
                                </div>
                                <div style="font-size: 1.125rem; font-weight: 600;">
                                    {{ $pengaduan->updated_at->format('d M Y') }}
                                </div>
                                <div style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 0.25rem;">
                                    {{ $pengaduan->updated_at->format('H:i') }} WIB
                                </div>
                            </div>
                        </div>

                        <!-- Detail Laporan -->
                        <div>
                            <h3 style="margin-bottom: 1.5rem;">DETAIL LAPORAN</h3>
                            <div style="font-size: 1.125rem; line-height: 1.8; color: var(--color-gray-800); white-space: pre-wrap;">{{ $pengaduan->detail_laporan }}</div>
                        </div>

                        <!-- Foto Bukti -->
                        @if($pengaduan->gambar)
                        <div>
                            <h3 style="margin-bottom: 1.5rem;">FOTO BUKTI</h3>
                            <div style="border: 2px solid var(--color-black); padding: 1rem; background: var(--color-gray-50);">
                                <img 
                                    src="{{ asset('uploads/pengaduan/' . $pengaduan->gambar) }}" 
                                    alt="Foto bukti pengaduan"
                                    style="width: 100%; height: auto; display: block; filter: grayscale(100%) contrast(1.1);">
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Right Column - Update Form -->
                    <div>
                        <div style="position: sticky; top: 100px;">
                            <div style="border: 2px solid var(--color-black); padding: 2rem; background: var(--color-white);">
                                <h3 style="margin-bottom: 2rem;">UPDATE STATUS</h3>
                                
                                <form action="{{ route('petugas.laporan.update-status', $pengaduan->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mono-form-group">
                                        <label class="mono-label" for="status">Status</label>
                                        <select id="status" name="status" class="mono-select" required>
                                            <option value="diajukan" {{ $pengaduan->status == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                            <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="ditolak" {{ $pengaduan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>

                                    <div class="mono-form-group">
                                        <label class="mono-label" for="catatan_petugas">Catatan</label>
                                        <textarea 
                                            id="catatan_petugas" 
                                            name="catatan_petugas" 
                                            class="mono-textarea"
                                            placeholder="Berikan catatan atau update progress..."
                                            style="min-height: 150px;">{{ old('catatan_petugas', $pengaduan->catatan_petugas) }}</textarea>
                                        <p style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 0.5rem;">
                                            Max 500 karakter
                                        </p>
                                    </div>

                                    <button type="submit" class="mono-btn mono-btn-primary" style="width: 100%;">
                                        Update
                                    </button>
                                </form>

                                @if($pengaduan->catatan_petugas)
                                <div class="mono-divider"></div>
                                <div>
                                    <h6 style="margin-bottom: 1rem; color: var(--color-gray-600);">CATATAN SAAT INI</h6>
                                    <div style="font-size: 0.875rem; line-height: 1.7; color: var(--color-gray-700); background: var(--color-gray-50); padding: 1rem;">
                                        {{ $pengaduan->catatan_petugas }}
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="mono-divider"></div>

                            <a href="{{ route('petugas.dashboard') }}" class="mono-btn mono-btn-ghost" style="width: 100%; text-align: center;">
                                ← Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer style="border-top: 1px solid var(--color-gray-200); padding: 3rem 0; margin-top: 4rem;">
        <div class="mono-container">
            <div style="text-align: center; color: var(--color-gray-500); font-size: 0.875rem;">
                <p>&copy; {{ date('Y') }} SARPAS — Sistem Pengaduan Sarana Prasarana</p>
            </div>
        </div>
    </footer>

    <script>
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>
