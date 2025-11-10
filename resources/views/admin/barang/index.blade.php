@extends('layouts.admin')

@section('title', 'Kelola Barang')

@section('header-actions')
<a href="{{ route('admin.barang.create') }}" style="background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>
    Tambah Barang
</a>
@endsection

@section('content')
<div class="content-section">
    @if($barang->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Lokasi</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barang as $b)
                <tr>
                    <td><strong>{{ $b->nama_barang }}</strong></td>
                    <td>
                        <span style="background: #DBEAFE; color: #1E40AF; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8125rem; font-weight: 600;">
                            📍 {{ $b->nama_lokasi }}
                        </span>
                    </td>
                    <td><small style="color: #666;">{{ $b->deskripsi ?? '-' }}</small></td>
                    <td>
                        @if($b->aktif)
                            <span class="status-badge badge-active">✓ Aktif</span>
                        @else
                            <span class="status-badge badge-inactive">✕ Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.barang.edit', $b->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.barang.destroy', $b->id) }}" method="POST" style="display: inline;"
                                  onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
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
            <div class="empty-state-icon">📦</div>
            <p>Belum ada barang terdaftar</p>
        </div>
    @endif
</div>
@endsection
