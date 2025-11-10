@extends('layouts.admin')

@section('title', 'Kelola Petugas')

@section('header-actions')
<a href="{{ route('admin.petugas.create') }}" style="background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>
    Tambah Petugas
</a>
@endsection

@section('content')
<div class="content-section">
    @if($petugas->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Tanggal Daftar</th>
                    <th>Total Ditangani</th>
                    <th>Selesai</th>
                    <th>Proses</th>
                </tr>
            </thead>
            <tbody>
                @foreach($petugas as $p)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700;">
                                {{ strtoupper(substr($p->nama_pengguna, 0, 1)) }}
                            </div>
                            <strong>{{ $p->nama_pengguna }}</strong>
                        </div>
                    </td>
                    <td><code style="background: #f5f5f5; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.875rem;">{{ $p->username }}</code></td>
                    <td><small style="color: #999;">{{ $p->created_at->format('d/m/Y') }}</small></td>
                    <td>
                        <span style="background: #DBEAFE; color: #1E40AF; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8125rem; font-weight: 600;">
                            {{ $p->total_handled }}
                        </span>
                    </td>
                    <td>
                        <span style="background: #D1FAE5; color: #059669; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8125rem; font-weight: 600;">
                            ✓ {{ $p->completed }}
                        </span>
                    </td>
                    <td>
                        <span style="background: #E9D5FF; color: #7C3AED; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8125rem; font-weight: 600;">
                            🔧 {{ $p->in_progress }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">🔧</div>
            <p>Belum ada petugas terdaftar</p>
        </div>
    @endif
</div>
@endsection
