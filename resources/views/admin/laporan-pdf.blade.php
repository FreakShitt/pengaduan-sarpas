<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Sarpras</title>
    <style>
        @page {
            margin: 2cm;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #1a1a1a;
        }
        .header h1 {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 5px;
            color: #1a1a1a;
        }
        .header h2 {
            font-size: 14pt;
            font-weight: normal;
            color: #666;
            margin-bottom: 10px;
        }
        .meta-info {
            margin-bottom: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-left: 4px solid #c5975f;
        }
        .meta-info table {
            width: 100%;
        }
        .meta-info td {
            padding: 3px 0;
        }
        .meta-info td:first-child {
            width: 150px;
            font-weight: bold;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .data-table th {
            background: #1a1a1a;
            color: white;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10pt;
        }
        .data-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            font-size: 10pt;
        }
        .data-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        .status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
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
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border: 1px solid #ddd;
        }
        .summary h3 {
            margin-bottom: 10px;
            color: #1a1a1a;
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
    <div class="header">
        <h1>LAPORAN PENGADUAN SARANA DAN PRASARANA</h1>
        <h2>Sistem Pengaduan Sarpras</h2>
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ $printed_at }}</td>
            </tr>
            @if($filters['start_date'] || $filters['end_date'])
            <tr>
                <td>Periode</td>
                <td>: 
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
                </td>
            </tr>
            @endif
            @if($filters['status'])
            <tr>
                <td>Status</td>
                <td>: {{ ucfirst($filters['status']) }}</td>
            </tr>
            @endif
            @if($filters['lokasi'])
            <tr>
                <td>Lokasi</td>
                <td>: {{ $filters['lokasi'] }}</td>
            </tr>
            @endif
            <tr>
                <td>Total Laporan</td>
                <td>: {{ $pengaduans->count() }} laporan</td>
            </tr>
        </table>
    </div>

    @if($pengaduans->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">Pelapor</th>
                <th style="width: 15%;">Lokasi</th>
                <th style="width: 15%;">Barang</th>
                <th style="width: 25%;">Detail</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduans as $index => $p)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($p->tanggal_laporan)->locale('id')->isoFormat('D MMM YYYY') }}</td>
                <td>{{ $p->user->nama_pengguna ?? '-' }}</td>
                <td>{{ $p->lokasi }}</td>
                <td>{{ $p->barang }}</td>
                <td>{{ Str::limit($p->detail_laporan, 80) }}</td>
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
        <p>Dokumen ini dicetak secara otomatis dari Sistem Pengaduan Sarpras</p>
        <p>{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm:ss') }}</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 500);
        }
    </script>
</body>
</html>
