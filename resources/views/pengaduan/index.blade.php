<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reports — Pengaduan Sarpas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    <header class="mono-header">
        <div class="mono-container">
            <nav class="mono-nav">
                <div class="mono-logo">SARPAS</div>
                <button class="mobile-menu-btn" onclick="toggleMenu()">☰</button>
                <ul class="mono-nav-links" id="navLinks">
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('pengaduan.index') }}" class="active">Pengaduan</a></li>
                    <li><a href="{{ route('pengaduan.create') }}">Buat Laporan</a></li>
                    <li class="show-mobile" style="border-top: 1px solid var(--color-gray-200); padding-top: var(--space-3); margin-top: var(--space-3);">
                        <div style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">{{ Auth::user()->nama_pengguna }}</div>
                        <div style="font-size: 0.75rem; color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: var(--space-3);">{{ Auth::user()->role }}</div>
                        <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" class="mono-btn mono-btn-sm" style="width: 100%;">Logout</button>
                        </form>
                    </li>
                </ul>
                <div class="hide-mobile" style="display: flex; align-items: center; gap: 2rem;">
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
                <h1 style="font-size: 4rem; margin-bottom: 1rem;">MY REPORTS</h1>
                <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                    Daftar semua pengaduan yang telah Anda buat
                </p>
            </div>
        </section>

        <!-- Alerts -->
        @if (session('success'))
        <section style="background: var(--color-gray-50); padding: 1.5rem 0; border-bottom: 1px solid var(--color-gray-200);">
            <div class="mono-container">
                <div class="mono-alert mono-alert-success">
                    {{ session('success') }}
                </div>
            </div>
        </section>
        @endif

        @if (session('error'))
        <section style="background: var(--color-black); padding: 1.5rem 0; border-bottom: 1px solid var(--color-black);">
            <div class="mono-container">
                <div class="mono-alert mono-alert-error">
                    {{ session('error') }}
                </div>
            </div>
        </section>
        @endif

        <!-- Reports List -->
        <section class="mono-section">
            <div class="mono-container">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem;">
                    <div>
                        <h6 style="color: var(--color-gray-600); margin-bottom: 0.5rem;">Total: {{ $pengaduans->count() }} Laporan</h6>
                    </div>
                    <a href="{{ route('pengaduan.create') }}" class="mono-btn mono-btn-primary">+ Buat Laporan Baru</a>
                </div>

                @if($pengaduans->count() > 0)
                    <div style="display: grid; gap: 2rem;">
                        @foreach($pengaduans as $pengaduan)
                        <div class="mono-card" style="padding: 2rem;">
                            <div style="display: grid; grid-template-columns: 1fr auto; gap: 2rem; align-items: start;">
                                <!-- Main Info -->
                                <div>
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                        <h3 style="margin: 0;">{{ $pengaduan->lokasi }} — {{ $pengaduan->barang }}</h3>
                                        @if($pengaduan->status == 'diajukan')
                                            <span class="mono-badge">{{ ucfirst($pengaduan->status) }}</span>
                                        @elseif($pengaduan->status == 'diproses')
                                            <span class="mono-badge">{{ ucfirst($pengaduan->status) }}</span>
                                        @elseif($pengaduan->status == 'selesai')
                                            <span class="mono-badge mono-badge-filled">{{ ucfirst($pengaduan->status) }}</span>
                                        @else
                                            <span class="mono-badge mono-badge-outlined">{{ ucfirst($pengaduan->status) }}</span>
                                        @endif
                                    </div>

                                    <div style="color: var(--color-gray-700); line-height: 1.7; margin-bottom: 1.5rem;">
                                        {{ Str::limit($pengaduan->detail_laporan, 200) }}
                                    </div>

                                    <div style="display: flex; gap: 2rem; font-size: 0.875rem; color: var(--color-gray-600);">
                                        <div>
                                            <strong style="color: var(--color-black);">ID:</strong> #{{ $pengaduan->id }}
                                        </div>
                                        <div>
                                            <strong style="color: var(--color-black);">Tanggal:</strong> {{ $pengaduan->created_at->format('d M Y, H:i') }} WIB
                                        </div>
                                        @if($pengaduan->is_temporary_item)
                                        <div>
                                            <span class="mono-badge mono-badge-outlined" style="font-size: 0.75rem;">Barang Baru</span>
                                        </div>
                                        @endif
                                    </div>

                                    @if($pengaduan->catatan_petugas)
                                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--color-gray-200);">
                                        <div style="font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; margin-bottom: 0.5rem; color: var(--color-gray-600);">
                                            Catatan Petugas
                                        </div>
                                        <div style="color: var(--color-gray-700);">
                                            {{ $pengaduan->catatan_petugas }}
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div style="text-align: right;">
                                    <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="mono-btn mono-btn-ghost">
                                        Detail →
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 6rem 2rem; border: 2px solid var(--color-gray-200);">
                        <h2 style="color: var(--color-gray-500); font-weight: 400; margin-bottom: 1rem;">Belum ada pengaduan</h2>
                        <p style="color: var(--color-gray-400); margin-bottom: 3rem; font-size: 1.125rem;">
                            Mulai buat laporan pengaduan untuk melaporkan kerusakan atau masalah fasilitas
                        </p>
                        <a href="{{ route('pengaduan.create') }}" class="mono-btn mono-btn-primary mono-btn-lg">
                            Buat Laporan Pertama
                        </a>
                    </div>
                @endif
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
        // Mobile menu toggle
        function toggleMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('active');
        }

        document.documentElement.style.scrollBehavior = 'smooth';

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('mono-fade-in');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.mono-card').forEach(card => {
            observer.observe(card);
        });
    </script>
</body>
</html>
