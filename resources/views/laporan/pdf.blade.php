<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Semua Transaksi</title>
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
        .group {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .group-header {
            background: #f5f5f5;
            padding: 10px;
            margin-bottom: 10px;
            border-left: 4px solid #333;
        }
        .group-header h3 {
            margin: 0;
            font-size: 16px;
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
        <h1>LAPORAN SEMUA TRANSAKSI</h1>
        <p>Restoran App</p>
        <p>Tanggal: {{ date('d F Y') }}</p>
    </div>

    @foreach($groupedTransaksis as $group)
    <div class="group">
        <div class="group-header">
            <h3>{{ $group['pelanggan']->namapelanggan ?? 'Pelanggan Tidak Diketahui' }}</h3>
            <p>
                @if(isset($group['pelanggan']->nohp))
                    Telp: {{ $group['pelanggan']->nohp }}
                @endif
                @if(isset($group['pelanggan']->alamat))
                    | Alamat: {{ $group['pelanggan']->alamat }}
                @endif
            </p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Total</th>
                    <th style="text-align: center;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($group['transaksis'] as $transaksi)
                <tr>
                    <td>{{ $transaksi['menu']->namamenu ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $transaksi['jumlah'] }}</td>
                    <td style="text-align: right;">Rp {{ number_format($transaksi['total'], 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $transaksi['tanggal']->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total">
                    <td colspan="2">TOTAL</td>
                    <td style="text-align: right;">Rp {{ number_format($group['total_semua'], 0, ',', '.') }}</td>
                    <td style="text-align: center;">
                        <div style="margin-bottom: 2px;">Bayar: Rp {{ number_format($group['bayar_semua'], 0, ',', '.') }}</div>
                        <div style="margin-bottom: 2px;">Kembalian: Rp {{ number_format($group['kembalian_semua'], 0, ',', '.') }}</div>
                        <div style="font-size: 11px;">Kasir: {{ $group['kasir']->name ?? $group['kasir']->username ?? 'N/A' }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endforeach

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>

