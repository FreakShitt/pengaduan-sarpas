@extends('layouts.admin')

@section('title', 'Permintaan Item Baru')

@section('content')
<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06); display: flex; align-items: center; gap: 1rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
        <div style="width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); color: #D97706;">⏳</div>
        <div>
            <h3 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin: 0;">{{ \App\Models\ItemRequest::where('status', 'pending')->count() }}</h3>
            <p style="color: #666; font-size: 0.875rem; margin: 0.25rem 0 0; font-weight: 500;">Pending</p>
        </div>
    </div>
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06); display: flex; align-items: center; gap: 1rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
        <div style="width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%); color: #059669;">✅</div>
        <div>
            <h3 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin: 0;">{{ \App\Models\ItemRequest::where('status', 'approved')->count() }}</h3>
            <p style="color: #666; font-size: 0.875rem; margin: 0.25rem 0 0; font-weight: 500;">Disetujui</p>
        </div>
    </div>
    <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06); display: flex; align-items: center; gap: 1rem; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
        <div style="width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%); color: #DC2626;">❌</div>
        <div>
            <h3 style="font-size: 2rem; font-weight: 700; color: #1a1a1a; margin: 0;">{{ \App\Models\ItemRequest::where('status', 'rejected')->count() }}</h3>
            <p style="color: #666; font-size: 0.875rem; margin: 0.25rem 0 0; font-weight: 500;">Ditolak</p>
        </div>
    </div>
</div>

<!-- Filter -->
<div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06); margin-bottom: 2rem;">
    <form method="GET" action="{{ route('admin.item-requests') }}" style="display: flex; gap: 1rem; align-items: end;">
        <div style="flex: 1; max-width: 300px;">
            <label for="status" style="display: block; font-size: 0.875rem; font-weight: 600; color: #333; margin-bottom: 0.5rem;">Filter Status</label>
            <select name="status" id="status" style="width: 100%; padding: 0.75rem 1rem; border: 2px solid #e8e8e8; border-radius: 8px; font-size: 0.9375rem; background: white;">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
            </select>
        </div>
        <button type="submit" style="background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
            <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
            </svg>
            Filter
        </button>
        <a href="{{ route('admin.item-requests') }}" style="background: #f5f5f5; color: #666; padding: 0.75rem 1.5rem; border: 2px solid #e8e8e8; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block;">
            <svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Reset
        </a>
    </form>
</div>

<!-- Item Requests Table -->
<div class="content-section">
    @if($itemRequests->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>Pengaju</th>
                    <th>Lokasi</th>
                    <th>Nama Item</th>
                    <th>Deskripsi</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($itemRequests as $request)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem;">
                                {{ strtoupper(substr($request->requester->nama_pengguna ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #1a1a1a;">{{ $request->requester->nama_pengguna ?? 'Unknown' }}</div>
                                <small style="color: #999;">{{ $request->requester->username ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="background: #DBEAFE; color: #1E40AF; padding: 0.35rem 0.75rem; border-radius: 20px; font-size: 0.8125rem; font-weight: 600;">
                            📍 {{ $request->nama_lokasi }}
                        </span>
                    </td>
                    <td><strong>{{ $request->nama_barang }}</strong></td>
                    <td><small style="color: #666;">{{ Str::limit($request->deskripsi ?? '-', 50) }}</small></td>
                    <td><small style="color: #999;">{{ $request->created_at->format('d/m/Y H:i') }}</small></td>
                    <td>
                        @if($request->status == 'pending')
                            <span class="status-badge" style="background: #FEF3C7; color: #D97706;">⏳ Pending</span>
                        @elseif($request->status == 'approved')
                            <span class="status-badge badge-active">✅ Disetujui</span>
                        @else
                            <span class="status-badge badge-inactive">❌ Ditolak</span>
                        @endif
                    </td>
                    <td>
                        @if($request->status == 'pending')
                        <div class="action-buttons">
                            <form method="POST" action="{{ route('admin.item-requests.approve', $request->id) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-edit" style="background: #D1FAE5; color: #065F46;" onclick="return confirm('Setujui permintaan item ini?')">
                                    ✓ Setuju
                                </button>
                            </form>
                            <button type="button" class="btn-delete" onclick="openRejectModal({{ $request->id }}, '{{ $request->nama_barang }}')">
                                ✕ Tolak
                            </button>
                        </div>

                        <!-- Reject Modal -->
                        <div id="rejectModal{{ $request->id }}" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
                            <div style="background: white; border-radius: 16px; padding: 2rem; max-width: 500px; width: 90%;">
                                <form method="POST" action="{{ route('admin.item-requests.reject', $request->id) }}">
                                    @csrf
                                    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: #1a1a1a;">Tolak Permintaan Item</h3>
                                    
                                    <div style="margin-bottom: 1.5rem;">
                                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">Item:</label>
                                        <div style="background: #f5f5f5; padding: 0.75rem; border-radius: 8px; font-weight: 600;">{{ $request->nama_barang }}</div>
                                    </div>

                                    <div style="margin-bottom: 1.5rem;">
                                        <label for="review_note{{ $request->id }}" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #333;">
                                            Alasan Penolakan <span style="color: #DC2626;">*</span>
                                        </label>
                                        <textarea name="review_note" id="review_note{{ $request->id }}" required
                                            style="width: 100%; padding: 0.75rem; border: 2px solid #e8e8e8; border-radius: 8px; font-size: 0.9375rem; resize: vertical; min-height: 120px;"
                                            placeholder="Jelaskan alasan penolakan..."></textarea>
                                    </div>

                                    <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                                        <button type="button" onclick="closeRejectModal({{ $request->id }})" 
                                            style="background: #f5f5f5; color: #666; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                            Batal
                                        </button>
                                        <button type="submit" class="btn-delete">
                                            ✕ Tolak Permintaan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @else
                        <div style="color: #999; font-size: 0.875rem;">
                            <div style="margin-bottom: 0.25rem;">👤 {{ $request->reviewer->nama_pengguna ?? '-' }}</div>
                            @if($request->review_note)
                            <button type="button" onclick="openNoteModal({{ $request->id }})"
                                style="background: none; border: none; color: #c5975f; cursor: pointer; padding: 0; text-decoration: underline; font-size: 0.8125rem;">
                                💬 Lihat Catatan
                            </button>

                            <!-- Note Modal -->
                            <div id="noteModal{{ $request->id }}" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
                                <div style="background: white; border-radius: 16px; padding: 2rem; max-width: 500px; width: 90%;">
                                    <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: #1a1a1a;">Catatan Review</h3>
                                    
                                    <div style="margin-bottom: 1rem;">
                                        <strong>Item:</strong> {{ $request->nama_barang }}
                                    </div>
                                    <div style="margin-bottom: 1rem;">
                                        <strong>Status:</strong> 
                                        @if($request->status == 'approved')
                                            <span class="status-badge badge-active">Disetujui</span>
                                        @else
                                            <span class="status-badge badge-inactive">Ditolak</span>
                                        @endif
                                    </div>
                                    <div style="margin-bottom: 1.5rem;">
                                        <strong>Catatan:</strong>
                                        <div style="background: #f5f5f5; padding: 1rem; border-radius: 8px; margin-top: 0.5rem; border-left: 4px solid #c5975f;">
                                            {{ $request->review_note }}
                                        </div>
                                    </div>

                                    <button type="button" onclick="closeNoteModal({{ $request->id }})"
                                        style="background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.75rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%;">
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
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <p>Tidak ada permintaan item</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function openRejectModal(id, itemName) {
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
</script>
@endpush
