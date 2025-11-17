<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buat Laporan — Pengaduan Sarpas</title>
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
                    <li><a href="{{ route('pengaduan.index') }}">Pengaduan</a></li>
                    <li><a href="{{ route('pengaduan.create') }}" class="active">Buat Laporan</a></li>
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
                <h1 style="font-size: 4rem; margin-bottom: 1rem;">BUAT LAPORAN</h1>
                <p style="font-size: 1.25rem; color: var(--color-gray-600); max-width: 600px;">
                    Laporkan kerusakan atau masalah pada fasilitas sekolah
                </p>
            </div>
        </section>

        <!-- Form Section -->
        <section class="mono-section">
            <div class="mono-container" style="max-width: 800px;">
                
                @if ($errors->any())
                <div class="mono-alert mono-alert-error" style="margin-bottom: 2rem;">
                    <strong style="display: block; margin-bottom: 0.5rem;">Terdapat kesalahan:</strong>
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Lokasi -->
                    <div class="mono-form-group">
                        <label class="mono-label" for="lokasi">Lokasi <span style="color: var(--color-gray-400);">*</span></label>
                        <select id="lokasi" name="lokasi" class="mono-select" required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($lokasi as $lok)
                                <option value="{{ $lok }}" {{ old('lokasi') == $lok ? 'selected' : '' }}>{{ $lok }}</option>
                            @endforeach
                        </select>
                        <p style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 0.5rem;">
                            Pilih lokasi dimana kerusakan terjadi
                        </p>
                    </div>

                    <!-- Barang -->
                    <div class="mono-form-group">
                        <label class="mono-label" for="barang">Barang/Fasilitas <span style="color: var(--color-gray-400);">*</span></label>
                        <select id="barang" name="barang" class="mono-select" disabled>
                            <option value="">Pilih lokasi terlebih dahulu</option>
                        </select>
                        <p style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 0.5rem;">
                            Pilih barang atau fasilitas yang rusak
                        </p>
                    </div>

                    <!-- Checkbox for custom item -->
                    <div style="margin-bottom: 2rem;">
                        <label style="display: flex; align-items: center; gap: 0.75rem; cursor: pointer;">
                            <input type="checkbox" id="custom_item_checkbox" style="width: 18px; height: 18px; cursor: pointer;">
                            <span style="font-size: 0.875rem; font-weight: 500;">Barang tidak ada dalam daftar (input manual)</span>
                        </label>
                    </div>

                    <!-- Custom Item Input -->
                    <div id="custom_item_field" style="display: none;" class="mono-form-group">
                        <label class="mono-label" for="temporary_item_name">Nama Barang Baru <span style="color: var(--color-gray-400);">*</span></label>
                        <input 
                            type="text" 
                            id="temporary_item_name" 
                            name="temporary_item_name" 
                            class="mono-input"
                            placeholder="Contoh: Papan Tulis Elektrik">
                        <p style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 0.5rem;">
                            Masukkan nama barang yang belum terdaftar
                        </p>
                    </div>

                    <!-- Detail Laporan -->
                    <div class="mono-form-group">
                        <label class="mono-label" for="detail_laporan">Detail Laporan <span style="color: var(--color-gray-400);">*</span></label>
                        <textarea 
                            id="detail_laporan" 
                            name="detail_laporan" 
                            class="mono-textarea" 
                            required
                            placeholder="Jelaskan secara detail kondisi kerusakan, kapan terjadi, dan dampaknya..."
                            style="min-height: 180px;">{{ old('detail_laporan') }}</textarea>
                        <p style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 0.5rem;">
                            Semakin detail informasi yang diberikan, semakin mudah petugas menangani
                        </p>
                    </div>

                    <!-- Upload Gambar -->
                    <div class="mono-form-group">
                        <label class="mono-label" for="gambar">Foto Bukti (Opsional)</label>
                        <input 
                            type="file" 
                            id="gambar" 
                            name="gambar" 
                            class="mono-input"
                            accept="image/*">
                        <p style="font-size: 0.875rem; color: var(--color-gray-600); margin-top: 0.5rem;">
                            Format: JPG, PNG, JPEG (Max: 2MB)
                        </p>
                    </div>

                    <div class="mono-divider"></div>

                    <!-- Actions -->
                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                        <a href="{{ route('pengaduan.index') }}" class="mono-btn mono-btn-ghost">
                            Batal
                        </a>
                        <button type="submit" class="mono-btn mono-btn-primary">
                            Submit Laporan
                        </button>
                    </div>
                </form>
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

        // Smooth scroll
        document.documentElement.style.scrollBehavior = 'smooth';

        // Dynamic barang loading based on lokasi
        const lokasiSelect = document.getElementById('lokasi');
        const barangSelect = document.getElementById('barang');
        const customItemCheckbox = document.getElementById('custom_item_checkbox');
        const customItemField = document.getElementById('custom_item_field');
        const customBarangInput = document.getElementById('temporary_item_name');

        // Set barang required by default when lokasi is selected
        lokasiSelect.addEventListener('change', function() {
            const lokasi = this.value;
            
            if (!lokasi) {
                barangSelect.disabled = true;
                barangSelect.removeAttribute('required');
                barangSelect.innerHTML = '<option value="">Pilih lokasi terlebih dahulu</option>';
                return;
            }

            // Only set required if custom item is NOT checked
            if (!customItemCheckbox.checked) {
                barangSelect.setAttribute('required', 'required');
            }

            // Fetch barang via AJAX
            fetch(`/pengaduan/get-barang?lokasi=${encodeURIComponent(lokasi)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                barangSelect.disabled = false;
                barangSelect.innerHTML = '<option value="">Pilih Barang/Fasilitas</option>';
                
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item;
                    option.textContent = item;
                    barangSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                barangSelect.innerHTML = '<option value="">Error loading data</option>';
            });
        });

        // Custom item toggle
        customItemCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Show custom field
                customItemField.style.display = 'block';
                customBarangInput.setAttribute('required', 'required');
                
                // Disable and remove required from barang select
                barangSelect.removeAttribute('required');
                barangSelect.disabled = true;
                barangSelect.value = '';
            } else {
                // Hide custom field
                customItemField.style.display = 'none';
                customBarangInput.removeAttribute('required');
                customBarangInput.value = '';
                
                // Enable barang select and set required if lokasi is selected
                if (lokasiSelect.value) {
                    barangSelect.disabled = false;
                    barangSelect.setAttribute('required', 'required');
                }
            }
        });

        // Image preview (optional enhancement)
        const gambarInput = document.getElementById('gambar');
        gambarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                }
            }
        });
    </script>
</body>
</html>
