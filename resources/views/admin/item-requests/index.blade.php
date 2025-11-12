<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Requests — Pengaduan Sarpas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    <header class="mono-header">
        <div class="mono-container">
            <nav class="mono-nav">
                <div class="mono-logo">SARPAS / ADMIN</div>
                <ul class="mono-nav-links">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.laporan') }}">Laporan</a></li>
                    <li><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li><a href="{{ route('admin.petugas.index') }}">Petugas</a></li>
                    <li><a href="{{ route('admin.lokasi.index') }}">Lokasi</a></li>
                    <li><a href="{{ route('admin.barang.index') }}">Barang</a></li>
                    <li><a href="{{ route('admin.item-requests.index') }}" class="active">Item Requests</a></li>
                </ul>
                <div style="display: flex; align-items: center; gap: 2rem;">
                    <div style="text-align: right;">
                        <div style="font-size: 0.875rem; font-weight: 600;">{{ Auth::user()->nama_pengguna }}</div>
                        <div style="font-size: 0.75rem; color: var(--color-gray-600); text-transform: uppercase; letter-spacing: 0.05em;">Administrator</div>
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
                <h1 style="font-size: 4rem; margin-bottom: 1rem;">ITEM REQUESTS</h1>
                <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                    Review & Approve Permintaan Barang Baru
                </p>
            </div>
        </section>

        @if(session('success'))
        <section class="mono-section" style="padding: 2rem 0;">
            <div class="mono-container">
                <div style="background: var(--color-green-50); border-left: 4px solid var(--color-green-600); padding: 1rem 1.5rem; border-radius: 8px;">
                    <p style="color: var(--color-green-600); font-weight: 600; margin: 0;">{{ session('success') }}</p>
                </div>
            </div>
        </section>
        @endif

        @if(session('error'))
        <section class="mono-section" style="padding: 2rem 0;">
            <div class="mono-container">
                <div style="background: var(--color-red-50); border-left: 4px solid var(--color-red-600); padding: 1rem 1.5rem; border-radius: 8px;">
                    <p style="color: var(--color-red-600); font-weight: 600; margin: 0;">{{ session('error') }}</p>
                </div>
            </div>
        </section>
        @endif

        <!-- Stats -->
        <section class="mono-section" style="background: var(--color-gray-50);">
            <div class="mono-container">
                <div class="mono-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ \App\Models\ItemRequest::where('status', 'pending')->count() }}</div>
                        <div class="mono-stat-label">Pending</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ \App\Models\ItemRequest::where('status', 'approved')->count() }}</div>
                        <div class="mono-stat-label">Disetujui</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ \App\Models\ItemRequest::where('status', 'rejected')->count() }}</div>
                        <div class="mono-stat-label">Ditolak</div>
                    </div>
                    <div class="mono-stat-card">
                        <div class="mono-stat-number">{{ \App\Models\ItemRequest::count() }}</div>
                        <div class="mono-stat-label">Total Requests</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter -->
        <section class="mono-section">
            <div class="mono-container">
                <form method="GET" action="{{ route('admin.item-requests.index') }}" style="display: flex; gap: 1rem; align-items: end; margin-bottom: 3rem;">
                    <div style="flex: 1; max-width: 300px;">
                        <label for="status" style="display: block; font-size: 0.875rem; font-weight: 600; color: var(--color-gray-700); margin-bottom: 0.5rem;">Filter Status</label>
                            <select name="status" id="status" style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: 8px; font-size: 0.9375rem; background: white;">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                    </div>
                    <button type="submit" class="mono-btn">Filter</button>
                    <a href="{{ route('admin.item-requests.index') }}" class="mono-btn mono-btn-ghost">Reset</a>
                </form>

                <!-- Data Table -->
                @if($itemRequests->count() > 0)
                    <table class="mono-table">
                        <thead>
                            <tr>
                                <th>PENGAJU</th>
                                <th>LOKASI</th>
                                <th>NAMA ITEM</th>
                                <th>DESKRIPSI</th>
                                <th>TANGGAL</th>
                                <th>STATUS</th>
                                <th style="text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($itemRequests as $request)
                                        <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, var(--color-purple-500) 0%, var(--color-purple-600) 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem;">
                                            {{ strtoupper(substr($request->requester->nama_pengguna ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;">{{ $request->requester->nama_pengguna ?? 'Unknown' }}</div>
                                            <small style="color: var(--color-gray-600);">{{ $request->requester->username ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="mono-badge">
                                        {{ $request->nama_lokasi }}
                                    </span>
                                </td>
                                <td><strong>{{ $request->nama_barang }}</strong></td>
                                <td style="max-width: 300px; color: var(--color-gray-600);">
                                    {{ Str::limit($request->deskripsi ?? '-', 50) }}
                                </td>
                                <td style="color: var(--color-gray-600);">{{ $request->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($request->status == 'pending')
                                        <span class="mono-badge">Pending</span>
                                    @elseif($request->status == 'approved')
                                        <span class="mono-badge mono-badge-filled">Disetujui</span>
                                    @else
                                        <span class="mono-badge mono-badge-outlined">Ditolak</span>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                <td style="text-align: center;">
                                    @if($request->status == 'pending')
                                    <div style="display: inline-flex; gap: 0.5rem;">
                                        <form method="POST" action="{{ route('admin.item-requests.approve', $request->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="mono-btn mono-btn-sm" 
                                                    onclick="return confirm('Setujui permintaan item ini dan tambahkan ke daftar barang?')">
                                                Setuju
                                            </button>
                                        </form>
                                        <button type="button" class="mono-btn mono-btn-sm mono-btn-outlined" 
                                                onclick="openRejectModal({{ $request->id }})">
                                            Tolak
                                        </button>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div id="rejectModal{{ $request->id }}" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
                                        <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                                            <form method="POST" action="{{ route('admin.item-requests.reject', $request->id) }}">
                                                @csrf
                                                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">Tolak Permintaan Item</h3>
                                                
                                                <div style="margin-bottom: 1.5rem;">
                                                    <label style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Item:</label>
                                                    <div style="background: var(--color-gray-100); padding: 0.75rem; border-radius: 8px; font-weight: 600;">{{ $request->nama_barang }}</div>
                                                </div>

                                                <div style="margin-bottom: 1.5rem;">
                                                    <label for="review_note{{ $request->id }}" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">
                                                        Alasan Penolakan <span style="color: var(--color-red-600);">*</span>
                                                    </label>
                                                    <textarea name="review_note" id="review_note{{ $request->id }}" required
                                                        style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-gray-200); border-radius: 8px; font-size: 0.9375rem; resize: vertical; min-height: 120px; font-family: inherit;"
                                                        placeholder="Jelaskan alasan penolakan..."></textarea>
                                                </div>

                                                <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                                                    <button type="button" onclick="closeRejectModal({{ $request->id }})" class="mono-btn mono-btn-ghost">
                                                        Batal
                                                    </button>
                                                    <button type="submit" class="mono-btn">
                                                        Tolak Permintaan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @else
                                    <div style="text-align: left;">
                                        <div style="margin-bottom: 0.25rem; font-size: 0.875rem;">
                                            <strong>Review by:</strong> {{ $request->reviewer->nama_pengguna ?? '-' }}
                                        </div>
                                        @if($request->review_note)
                                        <button type="button" onclick="openNoteModal({{ $request->id }})"
                                            class="mono-btn mono-btn-sm mono-btn-ghost" style="font-size: 0.8125rem;">
                                            Lihat Catatan
                                        </button>

                                        <!-- Note Modal -->
                                        <div id="noteModal{{ $request->id }}" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
                                            <div style="background: white; border-radius: 12px; padding: 2rem; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                                                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">Catatan Review</h3>
                                                
                                                <div style="margin-bottom: 1rem;">
                                                    <strong>Item:</strong> {{ $request->nama_barang }}
                                                </div>
                                                <div style="margin-bottom: 1rem;">
                                                    <strong>Status:</strong> 
                                                    @if($request->status == 'approved')
                                                        <span class="mono-badge mono-badge-filled">Disetujui</span>
                                                    @else
                                                        <span class="mono-badge mono-badge-outlined">Ditolak</span>
                                                    @endif
                                                </div>
                                                <div style="margin-bottom: 1.5rem;">
                                                    <strong>Catatan:</strong>
                                                    <div style="background: var(--color-gray-50); padding: 1rem; border-radius: 8px; margin-top: 0.5rem; border-left: 4px solid var(--color-yellow-600);">
                                                        {{ $request->review_note }}
                                                    </div>
                                                </div>

                                                <button type="button" onclick="closeNoteModal({{ $request->id }})" class="mono-btn" style="width: 100%;">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div style="margin-top: 2rem;">
                        {{ $itemRequests->links() }}
                    </div>
                @else
                    <div style="text-align: center; padding: 6rem 0; border: 2px solid var(--color-gray-200);">
                        <div style="font-size: 6rem; margin-bottom: 1.5rem; opacity: 0.2;">📋</div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Tidak ada permintaan item</h3>
                        <p style="color: var(--color-gray-600);">Semua permintaan barang baru akan muncul di sini</p>
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
        // Smooth scroll
        document.documentElement.style.scrollBehavior = 'smooth';

        // Fade in animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('mono-fade-in');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.mono-section').forEach(section => {
            observer.observe(section);
        });

        // Modal functions
        function openRejectModal(id) {
            document.getElementById('rejectModal' + id).style.display = 'flex';
        }

        function closeRejectModal(id) {
            document.getElementById('rejectModal' + id).style.display = 'none';
        }

        function openNoteModal(id) {
            document.getElementById('noteModal' + id).style.display = 'flex';
        }

        function closeNoteModal(id) {
            document.getElementById('noteModal' + id).style.display = 'none';
        }

        // Close modal on outside click
        window.onclick = function(event) {
            if (event.target.id && (event.target.id.includes('rejectModal') || event.target.id.includes('noteModal'))) {
                event.target.style.display = 'none';
            }
        }

        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[style*="color-green-50"], [style*="color-red-50"]');
            alerts.forEach(alert => {
                if (alert.parentElement && alert.parentElement.parentElement) {
                    const section = alert.parentElement.parentElement;
                    section.style.transition = 'opacity 0.5s';
                    section.style.opacity = '0';
                    setTimeout(() => section.remove(), 500);
                }
            });
        }, 5000);
    </script>
</body>
</html>