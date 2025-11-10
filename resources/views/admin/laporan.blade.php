@extends('layouts.admin')

@section('title', 'Laporan Pengaduan')

@section('content')
<!-- Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div style="background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center;">
        <div style="font-size: 0.75rem; color: #999; margin-bottom: 0.5rem;">TOTAL</div>
        <div style="font-size: 1.75rem; font-weight: 700; color: #3B82F6;">{{ $stats['total'] }}</div>
    </div>
    <div style="background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center;">
        <div style="font-size: 0.75rem; color: #999; margin-bottom: 0.5rem;">DIAJUKAN</div>
        <div style="font-size: 1.75rem; font-weight: 700; color: #F59E0B;">{{ $stats['diajukan'] }}</div>
    </div>
    <div style="background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center;">
        <div style="font-size: 0.75rem; color: #999; margin-bottom: 0.5rem;">DIPROSES</div>
        <div style="font-size: 1.75rem; font-weight: 700; color: #8B5CF6;">{{ $stats['diproses'] }}</div>
    </div>
    <div style="background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center;">
        <div style="font-size: 0.75rem; color: #999; margin-bottom: 0.5rem;">SELESAI</div>
        <div style="font-size: 1.75rem; font-weight: 700; color: #10B981;">{{ $stats['selesai'] }}</div>
    </div>
    <div style="background: white; padding: 1rem; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); text-align: center;">
        <div style="font-size: 0.75rem; color: #999; margin-bottom: 0.5rem;">DITOLAK</div>
        <div style="font-size: 1.75rem; font-weight: 700; color: #EF4444;">{{ $stats['ditolak'] }}</div>
    </div>
</div>

<!-- Filter & Export -->
<div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.06); margin-bottom: 2rem;">
    <form method="GET" action="{{ route('admin.laporan') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #333; margin-bottom: 0.5rem;">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" style="width: 100%; padding: 0.75rem; border: 2px solid #e8e8e8; border-radius: 8px;">
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #333; margin-bottom: 0.5rem;">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" style="width: 100%; padding: 0.75rem; border: 2px solid #e8e8e8; border-radius: 8px;">
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #333; margin-bottom: 0.5rem;">Status</label>
            <select name="status" style="width: 100%; padding: 0.75rem; border: 2px solid #e8e8e8; border-radius: 8px;">
                <option value="">Semua</option>
                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #333; margin-bottom: 0.5rem;">Lokasi</label>
            <select name="lokasi" style="width: 100%; padding: 0.75rem; border: 2px solid #e8e8e8; border-radius: 8px;">
                <option value="">Semua Lokasi</option>
                @foreach($lokasiList as $lok)
                    <option value="{{ $lok->nama_lokasi }}" {{ request('lokasi') == $lok->nama_lokasi ? 'selected' : '' }}>{{ $lok->nama_lokasi }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" style="background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Filter</button>
        <a href="{{ route('admin.laporan') }}" style="background: #f5f5f5; color: #666; padding: 0.75rem 1.5rem; border: 2px solid #e8e8e8; border-radius: 8px; font-weight: 600; text-decoration: none; text-align: center;">Reset</a>
    </form>

    <div style="display: flex; gap: 1rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e8e8e8;">
        <a href="{{ route('admin.laporan.export-pdf', request()->all()) }}" target="_blank" style="background: #DC2626; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            Export PDF
        </a>
        <a href="{{ route('admin.laporan.export-doc', request()->all()) }}" style="background: #2563EB; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Export DOC
        </a>
    </div>
</div>

<!-- Table -->
<div class="content-section">
    @if($laporan->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pengadu</th>
                    <th>Lokasi</th>
                    <th>Barang</th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporan as $l)
                <tr>
                    <td><small style="color: #999;">{{ $l->created_at->format('d/m/Y H:i') }}</small></td>
                    <td><strong>{{ $l->user->nama_pengguna }}</strong></td>
                    <td>
                        <span style="background: #DBEAFE; color: #1E40AF; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8125rem; font-weight: 600;">
                            📍 {{ $l->lokasi }}
                        </span>
                    </td>
                    <td>{{ $l->barang }}</td>
                    <td><small style="color: #666;">{{ Str::limit($l->detail_laporan, 50) }}</small></td>
                    <td>
                        @if($l->status === 'diajukan')
                            <span class="status-badge" style="background: #FEF3C7; color: #D97706;">⏳ Diajukan</span>
                        @elseif($l->status === 'diproses')
                            <span class="status-badge" style="background: #E9D5FF; color: #7C3AED;">🔧 Diproses</span>
                        @elseif($l->status === 'selesai')
                            <span class="status-badge badge-active">✅ Selesai</span>
                        @elseif($l->status === 'ditolak')
                            <span class="status-badge badge-inactive">❌ Ditolak</span>
                        @else
                            <span class="status-badge">{{ ucfirst($l->status ?? 'N/A') }}</span>
                        @endif
                    </td>
                    <td><small style="color: #666;">{{ $l->petugas ? $l->petugas->nama_pengguna : '-' }}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 2rem;">
            {{ $laporan->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <p>Tidak ada laporan ditemukan</p>
        </div>
    @endif
</div>
@endsection
