@extends('layouts.admin')

@section('title', 'Kelola User')

@section('header-actions')
<a href="{{ route('admin.users.create') }}" style="background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>
    Tambah User
</a>
@endsection

@section('content')
<!-- Siswa Section -->
<div class="content-section" style="margin-bottom: 2rem;">
    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #1a1a1a; display: flex; align-items: center; gap: 0.5rem;">
        <span style="font-size: 1.5rem;">🎓</span> Siswa ({{ $siswa->count() }})
    </h3>
    
    @if($siswa->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Tanggal Daftar</th>
                    <th>Total Pengaduan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $s)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                {{ strtoupper(substr($s->nama_pengguna, 0, 1)) }}
                            </div>
                            <strong>{{ $s->nama_pengguna }}</strong>
                        </div>
                    </td>
                    <td><code style="background: #f5f5f5; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem;">{{ $s->username }}</code></td>
                    <td><small style="color: #999;">{{ $s->created_at->format('d/m/Y') }}</small></td>
                    <td>
                        <span style="background: #E0E7FF; color: #4338CA; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8125rem; font-weight: 600;">
                            {{ $s->pengaduans->count() }} Pengaduan
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🎓</div>
            <p>Belum ada siswa terdaftar</p>
        </div>
    @endif
</div>

<!-- Guru Section -->
<div class="content-section">
    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.25rem; font-weight: 700; margin-bottom: 1rem; color: #1a1a1a; display: flex; align-items: center; gap: 0.5rem;">
        <span style="font-size: 1.5rem;">👨‍🏫</span> Guru ({{ $guru->count() }})
    </h3>
    
    @if($guru->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Tanggal Daftar</th>
                    <th>Total Pengaduan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($guru as $g)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                {{ strtoupper(substr($g->nama_pengguna, 0, 1)) }}
                            </div>
                            <strong>{{ $g->nama_pengguna }}</strong>
                        </div>
                    </td>
                    <td><code style="background: #f5f5f5; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem;">{{ $g->username }}</code></td>
                    <td><small style="color: #999;">{{ $g->created_at->format('d/m/Y') }}</small></td>
                    <td>
                        <span style="background: #E0E7FF; color: #4338CA; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8125rem; font-weight: 600;">
                            {{ $g->pengaduans->count() }} Pengaduan
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">👨‍🏫</div>
            <p>Belum ada guru terdaftar</p>
        </div>
    @endif
</div>
@endsection
