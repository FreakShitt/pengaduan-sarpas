@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Total Pengaduan -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">📊</div>
            <div>
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Total Pengaduan</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: #1a1a1a;">{{ $totalReports }}</div>
            </div>
        </div>
    </div>

    <!-- Pending -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">⏳</div>
            <div>
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Menunggu</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: #1a1a1a;">{{ $pendingReports }}</div>
            </div>
        </div>
    </div>

    <!-- Processing -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">🔧</div>
            <div>
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Diproses</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: #1a1a1a;">{{ $processingReports }}</div>
            </div>
        </div>
    </div>

    <!-- Completed -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #10B981 0%, #059669 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">✅</div>
            <div>
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Selesai</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: #1a1a1a;">{{ $completedReports }}</div>
            </div>
        </div>
    </div>

    <!-- Rejected -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">❌</div>
            <div>
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Ditolak</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: #1a1a1a;">{{ $rejectedReports }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Siswa -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">🎓</div>
            <div>
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Siswa</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: #1a1a1a;">{{ $totalSiswa }}</div>
            </div>
        </div>
    </div>

    <!-- Guru -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">👨‍🏫</div>
            <div>
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Guru</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: #1a1a1a;">{{ $totalGuru }}</div>
            </div>
        </div>
    </div>

    <!-- Petugas -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">🔧</div>
            <div>
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Petugas</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: #1a1a1a;">{{ $totalPetugas }}</div>
            </div>
        </div>
    </div>

    <!-- Lokasi -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #84CC16 0%, #65A30D 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">📍</div>
            <div>
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Lokasi</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: #1a1a1a;">{{ $totalLokasi }}</div>
            </div>
        </div>
    </div>

    <!-- Barang -->
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="width: 50px; height: 50px; border-radius: 10px; background: linear-gradient(135deg, #F97316 0%, #EA580C 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">📦</div>
            <div>
                <div style="font-size: 0.75rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px;">Barang</div>
                <div style="font-size: 1.75rem; font-weight: 700; color: #1a1a1a;">{{ $totalBarang }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Reports -->
<div class="content-section">
    <h2 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: #1a1a1a;">Pengaduan Terbaru</h2>
    
    @if($recentReports->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Pengadu</th>
                    <th>Lokasi</th>
                    <th>Barang</th>
                    <th>Status</th>
                    <th>Petugas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentReports as $report)
                <tr>
                    <td><small style="color: #999;">{{ $report->created_at->format('d/m/Y H:i') }}</small></td>
                    <td><strong>{{ $report->user->nama_pengguna ?? '-' }}</strong></td>
                    <td>
                        <span style="background: #DBEAFE; color: #1E40AF; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8125rem; font-weight: 600;">
                            📍 {{ $report->lokasi }}
                        </span>
                    </td>
                    <td>{{ $report->barang }}</td>
                    <td>
                        @if($report->status == 'diajukan')
                            <span class="status-badge" style="background: #FEF3C7; color: #D97706;">⏳ Diajukan</span>
                        @elseif($report->status == 'diproses')
                            <span class="status-badge" style="background: #E9D5FF; color: #7C3AED;">🔧 Diproses</span>
                        @elseif($report->status == 'selesai')
                            <span class="status-badge badge-active">✅ Selesai</span>
                        @else
                            <span class="status-badge badge-inactive">❌ Ditolak</span>
                        @endif
                    </td>
                    <td><small style="color: #666;">{{ $report->petugas->nama_pengguna ?? 'Belum ditugaskan' }}</small></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <p>Belum ada pengaduan</p>
        </div>
    @endif
</div>
@endsection
