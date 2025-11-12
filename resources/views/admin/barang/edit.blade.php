@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')
<div class="content-section">
    <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a1a1a;">
                Lokasi <span style="color: #dc2626;">*</span>
            </label>
            <select name="nama_lokasi" required 
                    style="width: 100%; padding: 0.75rem; border: 2px solid #e8e8e8; border-radius: 8px; font-size: 1rem; transition: all 0.2s;">
                <option value="">Pilih Lokasi</option>
                @foreach($lokasi as $lok)
                    <option value="{{ $lok->nama_lokasi }}" {{ (old('nama_lokasi', $barang->nama_lokasi) == $lok->nama_lokasi) ? 'selected' : '' }}>
                        {{ $lok->nama_lokasi }}
                    </option>
                @endforeach
            </select>
            @error('nama_lokasi')
                <small style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a1a1a;">
                Nama Barang <span style="color: #dc2626;">*</span>
            </label>
            <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required
                   style="width: 100%; padding: 0.75rem; border: 2px solid #e8e8e8; border-radius: 8px; font-size: 1rem; transition: all 0.2s;"
                   placeholder="Contoh: Meja, Kursi, Papan Tulis">
            @error('nama_barang')
                <small style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #1a1a1a;">
                Deskripsi
            </label>
            <textarea name="deskripsi" rows="4"
                      style="width: 100%; padding: 0.75rem; border: 2px solid #e8e8e8; border-radius: 8px; font-size: 1rem; transition: all 0.2s; resize: vertical;"
                      placeholder="Deskripsi barang (opsional)">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
            @error('deskripsi')
                <small style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: flex; align-items: center; cursor: pointer;">
                <input type="checkbox" name="aktif" value="1" {{ old('aktif', $barang->aktif) ? 'checked' : '' }}
                       style="width: 20px; height: 20px; margin-right: 0.5rem;">
                <span style="font-weight: 600; color: #1a1a1a;">Aktif</span>
            </label>
            <small style="color: #666; font-size: 0.875rem;">Hanya barang aktif yang dapat dipilih saat membuat pengaduan</small>
        </div>

        <div style="display: flex; gap: 1rem; padding-top: 1rem; border-top: 1px solid #e8e8e8;">
            <button type="submit" 
                    style="flex: 1; background: linear-gradient(135deg, #c5975f 0%, #d4a76a 100%); color: white; padding: 0.875rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);">
                Update Barang
            </button>
            <a href="{{ route('admin.barang.index') }}" 
               style="flex: 1; background: #f5f5f5; color: #666; padding: 0.875rem 1.5rem; border: none; border-radius: 8px; font-weight: 600; text-align: center; text-decoration: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); display: inline-block;">
                Batal
            </a>
        </div>
    </form>
</div>

<style>
    select:focus, input:focus, textarea:focus {
        outline: none;
        border-color: #c5975f;
        box-shadow: 0 0 0 3px rgba(197, 151, 95, 0.1);
    }

    button[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(197, 151, 95, 0.3);
    }

    a[href]:hover {
        background: #e8e8e8;
    }
</style>
@endsection
