<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan #{{ $pengaduan->id }} — Pengaduan Sarpas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    <header class="mono-header">
        <div class="mono-container">
            <nav class="mono-nav">
                <div class="mono-logo">SARPAS</div>
                <ul class="mono-nav-links">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('pengaduan.index') }}">Pengaduan</a></li>
                    <li><a href="{{ route('pengaduan.create') }}">Buat Laporan</a></li>
                </ul>
                <div style="display: flex; align-items: center; gap: 2rem;">
                    <div style="text-align: right;">
                        <div style="font-size: 0.875rem; font-weight: 600;">{{ Auth::user()->nama_pengguna }}</div>
                        <div style="font-size: 0.75rem; color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.05em;">{{ Auth::user()->role }}</div>
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

        <!-- Detail Section -->
        <section class="mono-section">
            <div class="mono-container" style="max-width: 900px;">
                <div style="display: grid; gap: 3rem;">
                    <!-- Meta Info -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; padding: 2rem; border: 1px solid var(--color-gray-200);">
                        <div>
                            <div style="font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-gray-600);">
                                Pelapor
                            </div>
                            <div style="font-size: 1.125rem; font-weight: 600;">
                                {{ $pengaduan->user ? $pengaduan->user->nama_pengguna : 'N/A' }}
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
                            @php
                                $encoded = strtr(base64_encode($pengaduan->gambar), '+/', '-_');
                                $imageUrl = route('image.serve', $encoded);
                            @endphp
                            <a href="{{ $imageUrl }}" target="_blank" style="display: block; cursor: pointer;" title="Klik untuk memperbesar gambar">
                                <img 
                                    src="{{ $imageUrl }}" 
                                    alt="Foto bukti pengaduan"
                                    style="width: 100%; height: auto; display: block; filter: grayscale(100%) contrast(1.1); transition: opacity 0.2s;"
                                    onmouseover="this.style.opacity='0.8'"
                                    onmouseout="this.style.opacity='1'"
                                    onerror="this.style.border='3px solid red'; this.alt='Gambar gagal dimuat'">
                            </a>
                            <p style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 0.5rem; text-align: center;">Klik gambar untuk memperbesar</p>
                        </div>
                    </div>
                    @endif

                    <!-- Catatan Petugas -->
                    @if($pengaduan->catatan_petugas)
                    <div style="background: var(--color-gray-50); padding: 2rem; border-left: 4px solid var(--color-black);">
                        <h6 style="margin-bottom: 1rem; color: var(--color-gray-600);">CATATAN PETUGAS</h6>
                        <div style="font-size: 1.125rem; line-height: 1.8; color: var(--color-gray-800);">
                            {{ $pengaduan->catatan_petugas }}
                        </div>
                    </div>
                    @endif

                    <!-- Catatan Admin -->
                    @if($pengaduan->catatan_admin)
                    <div style="background: var(--color-black); color: var(--color-white); padding: 2rem;">
                        <h6 style="margin-bottom: 1rem; color: var(--color-gray-300);">CATATAN ADMIN</h6>
                        <div style="font-size: 1.125rem; line-height: 1.8;">
                            {{ $pengaduan->catatan_admin }}
                        </div>
                    </div>
                    @endif

                    <div class="mono-divider-thick"></div>

                    <!-- Actions -->
                    <div style="display: flex; gap: 1rem;">
                        <a href="{{ route('pengaduan.index') }}" class="mono-btn mono-btn-ghost">
                            ← Kembali ke Daftar
                        </a>
                        @if($pengaduan->user_id == Auth::id() && $pengaduan->status == 'diajukan')
                        <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');" style="margin-left: auto;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="mono-btn" style="border-color: var(--color-gray-400); color: var(--color-gray-600);">
                                Hapus Laporan
                            </button>
                        </form>
                        @endif
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
