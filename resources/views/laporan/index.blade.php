@extends('layouts.app')
@section('title', 'Laporan Transaksi')
@section('content')
<div class="page-header">
    <h2>Laporan Transaksi</h2>
    <p>Laporan semua transaksi yang telah dilakukan</p>
</div>

@if(session('success'))
    <div class="alert alert-success" style="background: #D1FAE5; border: 1px solid #6EE7B7; color: #065F46; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <a href="{{ route('laporan.download.pdf') }}" style="background: #e74c3c; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-file-pdf"></i> Download PDF Semua
    </a>
</div>

@if($groupedTransaksis->count() > 0)
    @foreach($groupedTransaksis as $group)
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 24px; margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid #FAF9EE;">
            <div>
                <h3 style="color: #2c3e50; margin-bottom: 8px;">{{ $group['pelanggan']->namapelanggan ?? 'Pelanggan Tidak Diketahui' }}</h3>
                <p style="color: #7f8c8d; font-size: 0.9rem; margin: 0;">
                    @if(isset($group['pelanggan']->nohp))
                        Telp: {{ $group['pelanggan']->nohp }}
                    @endif
                    @if(isset($group['pelanggan']->alamat))
                        | Alamat: {{ $group['pelanggan']->alamat }}
                    @endif
                </p>
            </div>
            <div style="text-align: right;">
                <a href="{{ route('laporan.show', $group['id_pelanggan']) }}" style="background: #A2AF9B; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem; margin-right: 8px;">
                    <i class="fa-solid fa-eye"></i> Detail
                </a>
                <a href="{{ route('laporan.download.pdf.single', $group['id_pelanggan']) }}" style="background: #e74c3c; color: white; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-size: 0.9rem;">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                </a>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #FAF9EE; border-bottom: 2px solid #D4DED0;">
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Menu</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Jumlah</th>
                        <th style="padding: 12px; text-align: right; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Total</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($group['transaksis'] as $transaksi)
                    <tr style="border-bottom: 1px solid #EEEEEE;">
                        <td style="padding: 12px; color: #2c3e50;">{{ $transaksi['menu']->namamenu ?? 'N/A' }}</td>
                        <td style="padding: 12px; text-align: center; color: #2c3e50;">{{ $transaksi['jumlah'] }}</td>
                        <td style="padding: 12px; text-align: right; color: #2c3e50;">Rp {{ number_format($transaksi['total'], 0, ',', '.') }}</td>
                        <td style="padding: 12px; text-align: center; color: #7f8c8d; font-size: 0.85rem;">{{ $transaksi['tanggal']->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #FAF9EE; font-weight: 600;">
                        <td colspan="2" style="padding: 12px; color: #2c3e50;">TOTAL</td>
                        <td style="padding: 12px; text-align: right; color: #2c3e50;">Rp {{ number_format($group['total_semua'], 0, ',', '.') }}</td>
                        <td style="padding: 12px; text-align: center; color: #2c3e50;">
                            <div style="margin-bottom: 4px;">Bayar: Rp {{ number_format($group['bayar_semua'], 0, ',', '.') }}</div>
                            <div style="margin-bottom: 4px; color: #065F46;">Kembalian: Rp {{ number_format($group['kembalian_semua'], 0, ',', '.') }}</div>
                            <div style="font-size: 0.95rem; color: #2c3e50;">Kasir: {{ $group['kasir']->name ?? $group['kasir']->username ?? 'N/A' }}</div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endforeach
@else
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 40px; text-align: center;">
        <i class="fa-solid fa-file-chart-line" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.5; color: #7f8c8d;"></i>
        <p style="color: #7f8c8d;">Belum ada data transaksi</p>
    </div>
@endif
@endsection

