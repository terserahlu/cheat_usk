<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - {{ $groupedData['pelanggan']->namapelanggan ?? 'Pelanggan' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-section {
            margin-bottom: 20px;
            padding: 15px;
            background: #f5f5f5;
            border-left: 4px solid #333;
        }
        .info-section h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #333;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .total {
            font-weight: bold;
            background: #f0f0f0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI</h1>
        <p>Restoran App</p>
        <p>Tanggal: {{ date('d F Y') }}</p>
    </div>

    <div class="info-section">
        <h3>Informasi Pelanggan</h3>
        <div class="info-row">
            <div class="info-label">Nama Pelanggan:</div>
            <div>{{ $groupedData['pelanggan']->namapelanggan ?? 'N/A' }}</div>
        </div>
        @if(isset($groupedData['pelanggan']->jeniskelamin))
        <div class="info-row">
            <div class="info-label">Jenis Kelamin:</div>
            <div>{{ $groupedData['pelanggan']->jeniskelamin ? 'Laki-laki' : 'Perempuan' }}</div>
        </div>
        @endif
        @if(isset($groupedData['pelanggan']->nohp))
        <div class="info-row">
            <div class="info-label">No. HP:</div>
            <div>{{ $groupedData['pelanggan']->nohp }}</div>
        </div>
        @endif
        @if(isset($groupedData['pelanggan']->alamat))
        <div class="info-row">
            <div class="info-label">Alamat:</div>
            <div>{{ $groupedData['pelanggan']->alamat }}</div>
        </div>
        @endif
    </div>

    <h3 style="margin-bottom: 10px;">Detail Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>Menu</th>
                <th style="text-align: center;">Jumlah</th>
                <th style="text-align: right;">Total</th>
                <th style="text-align: center;">Meja</th>
                <th style="text-align: center;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groupedData['transaksis'] as $transaksi)
            <tr>
                <td>{{ $transaksi['menu']->namamenu ?? 'N/A' }}</td>
                <td style="text-align: center;">{{ $transaksi['jumlah'] }}</td>
                <td style="text-align: right;">Rp {{ number_format($transaksi['total'], 0, ',', '.') }}</td>
                <td style="text-align: center;">{{ $transaksi['meja']->nomer_meja ?? 'N/A' }}</td>
                <td style="text-align: center;">{{ $transaksi['tanggal']->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="2">TOTAL</td>
                <td style="text-align: right;">Rp {{ number_format($groupedData['total_semua'], 0, ',', '.') }}</td>
                <td colspan="2" style="text-align: center;">
                    <div style="margin-bottom: 2px;">Bayar: Rp {{ number_format($groupedData['bayar_semua'], 0, ',', '.') }}</div>
                    <div style="margin-bottom: 2px;">Kembalian: Rp {{ number_format($groupedData['kembalian_semua'], 0, ',', '.') }}</div>
                    <div style="font-size: 11px;">Kasir: {{ $groupedData['kasir']->name ?? $groupedData['kasir']->username ?? 'N/A' }}</div>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>

