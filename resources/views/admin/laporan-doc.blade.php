<!DOCTYPE html>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Sarpras</title>
    <style>
        @page Section1 {
            size: 8.5in 11.0in;
            margin: 1.0in 1.0in 1.0in 1.0in;
        }
        div.Section1 { page: Section1; }
        body {
            font-family: Calibri, Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #000;
        }
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin: 0 0 10px 0;
        }
        .header h2 {
            font-size: 14pt;
            font-weight: normal;
            margin: 0;
            color: #666;
        }
        .meta-info {
            margin: 20px 0;
            padding: 15px;
            background: #f5f5f5;
            border-left: 4px solid #c5975f;
        }
        .meta-row {
            margin: 5px 0;
        }
        .meta-label {
            font-weight: bold;
            display: inline-block;
            width: 150px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background: #1a1a1a;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #000;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .status {
            padding: 3px 8px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9pt;
            display: inline-block;
        }
        .status-pending { background: #FEF3C7; color: #92400E; }
        .status-diajukan { background: #FEF3C7; color: #92400E; }
        .status-proses { background: #DBEAFE; color: #1E40AF; }
        .status-diproses { background: #DBEAFE; color: #1E40AF; }
        .status-selesai { background: #D1FAE5; color: #065F46; }
        .status-ditolak { background: #FEE2E2; color: #991B1B; }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 9pt;
            color: #666;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="Section1">
        <div class="header">
            <h1>LAPORAN PENGADUAN SARANA DAN PRASARANA</h1>
            <h2>Sistem Pengaduan Sarpras</h2>
        </div>

        <div class="meta-info">
            <div class="meta-row">
                <span class="meta-label">Tanggal Cetak</span>
                <span>: {{ $printed_at }}</span>
            </div>
            @if($filters['start_date'] || $filters['end_date'])
            <div class="meta-row">
                <span class="meta-label">Periode</span>
                <span>: 
                    @if($filters['start_date'])
                        {{ \Carbon\Carbon::parse($filters['start_date'])->locale('id')->isoFormat('D MMMM YYYY') }}
                    @else
                        -
                    @endif
                    s/d 
                    @if($filters['end_date'])
                        {{ \Carbon\Carbon::parse($filters['end_date'])->locale('id')->isoFormat('D MMMM YYYY') }}
                    @else
                        Sekarang
                    @endif
                </span>
            </div>
            @endif
            @if($filters['status'])
            <div class="meta-row">
                <span class="meta-label">Status</span>
                <span>: {{ ucfirst($filters['status']) }}</span>
            </div>
            @endif
            @if($filters['lokasi'])
            <div class="meta-row">
                <span class="meta-label">Lokasi</span>
                <span>: {{ $filters['lokasi'] }}</span>
            </div>
            @endif
            <div class="meta-row">
                <span class="meta-label">Total Laporan</span>
                <span>: {{ $pengaduans->count() }} laporan</span>
            </div>
        </div>

        @if($pengaduans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 15%;">Pelapor</th>
                    <th style="width: 15%;">Lokasi</th>
                    <th style="width: 15%;">Barang</th>
                    <th style="width: 25%;">Detail Kerusakan</th>
                    <th style="width: 10%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengaduans as $index => $p)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_laporan)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                    <td>{{ $p->user->nama_pengguna ?? '-' }}<br><small>({{ ucfirst($p->user->role ?? '-') }})</small></td>
                    <td>{{ $p->lokasi }}</td>
                    <td>{{ $p->barang }}</td>
                    <td>{{ $p->detail_laporan }}</td>
                    <td>
                        @php
                            $statusClass = 'status-' . strtolower($p->status);
                            $statusText = $p->status;
                            if ($p->status == 'diajukan') $statusText = 'Pending';
                            elseif ($p->status == 'proses' || $p->status == 'diproses') $statusText = 'Proses';
                            elseif ($p->status == 'selesai') $statusText = 'Selesai';
                            elseif ($p->status == 'ditolak') $statusText = 'Ditolak';
                        @endphp
                        <span class="status {{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-data">
            Tidak ada data laporan untuk ditampilkan
        </div>
        @endif

        <div class="footer">
            <p><strong>Dokumen ini dicetak secara otomatis dari Sistem Pengaduan Sarpras</strong></p>
            <p>{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}</p>
        </div>
    </div>
</body>
</html>
