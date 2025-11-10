@extends('layouts.admin')

@section('title', 'Kelola Lokasi')

@section('header-actions')
<a href="{{ route('admin.lokasi.create') }}" style="background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>
    Tambah Lokasi
</a>
@endsection

@section('content')
<div class="content-section">
    @if($lokasi->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Lokasi</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Barang</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lokasi as $lok)
                <tr>
                    <td><strong>📍 {{ $lok->nama_lokasi }}</strong></td>
                    <td><small style="color: #666;">{{ $lok->deskripsi ?? '-' }}</small></td>
                    <td>
                        <span style="background: #E0E7FF; color: #4338CA; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8125rem; font-weight: 600;">
                            {{ $lok->barang_count }} Item
                        </span>
                    </td>
                    <td>
                        @if($lok->aktif)
                            <span class="status-badge badge-active">✓ Aktif</span>
                        @else
                            <span class="status-badge badge-inactive">✕ Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.lokasi.edit', $lok->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.lokasi.destroy', $lok->id) }}" method="POST" style="display: inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus lokasi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📍</div>
            <p>Belum ada lokasi terdaftar</p>
        </div>
    @endif
</div>
@endsection
