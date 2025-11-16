@extends('layouts.app')
@section('title', 'Detail Laporan')
@section('content')
<div class="page-header">
    <h2>Detail Laporan Transaksi</h2>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span>/</span>
        <a href="{{ route('laporan.index') }}">Laporan</a>
        <span>/</span>
        <span>Detail</span>
    </div>
</div>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <a href="{{ route('laporan.download.pdf.single', $groupedData['id_pelanggan']) }}" style="background: #e74c3c; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-file-pdf"></i> Download PDF
    </a>
</div>

<div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 30px;">
    <div style="margin-bottom: 30px; padding-bottom: 20px; border-bottom: 2px solid #FAF9EE;">
        <h3 style="color: #2c3e50; margin-bottom: 12px;">Informasi Pelanggan</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 16px;">
            <div>
                <label style="display: block; font-size: 0.85rem; color: #7f8c8d; margin-bottom: 4px;">Nama Pelanggan</label>
                <div style="font-weight: 600; color: #2c3e50;">{{ $groupedData['pelanggan']->namapelanggan ?? 'N/A' }}</div>
            </div>
            <div>
                <label style="display: block; font-size: 0.85rem; color: #7f8c8d; margin-bottom: 4px;">Jenis Kelamin</label>
                <div style="font-weight: 600; color: #2c3e50;">{{ isset($groupedData['pelanggan']->jeniskelamin) ? ($groupedData['pelanggan']->jeniskelamin ? 'Laki-laki' : 'Perempuan') : 'N/A' }}</div>
            </div>
            @if(isset($groupedData['pelanggan']->nohp))
            <div>
                <label style="display: block; font-size: 0.85rem; color: #7f8c8d; margin-bottom: 4px;">No. HP</label>
                <div style="font-weight: 600; color: #2c3e50;">{{ $groupedData['pelanggan']->nohp }}</div>
            </div>
            @endif
            @if(isset($groupedData['pelanggan']->alamat))
            <div>
                <label style="display: block; font-size: 0.85rem; color: #7f8c8d; margin-bottom: 4px;">Alamat</label>
                <div style="font-weight: 600; color: #2c3e50;">{{ $groupedData['pelanggan']->alamat }}</div>
            </div>
            @endif
        </div>
    </div>

    <h3 style="color: #2c3e50; margin-bottom: 20px;">Detail Transaksi</h3>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #FAF9EE; border-bottom: 2px solid #D4DED0;">
                    <th style="padding: 12px; text-align: left; font-weight: 600; color: #2c3e50;">Menu</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600; color: #2c3e50;">Jumlah</th>
                    <th style="padding: 12px; text-align: right; font-weight: 600; color: #2c3e50;">Total</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600; color: #2c3e50;">Meja</th>
                    <th style="padding: 12px; text-align: center; font-weight: 600; color: #2c3e50;">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupedData['transaksis'] as $transaksi)
                <tr style="border-bottom: 1px solid #EEEEEE;">
                    <td style="padding: 12px; color: #2c3e50;">{{ $transaksi['menu']->namamenu ?? 'N/A' }}</td>
                    <td style="padding: 12px; text-align: center; color: #2c3e50;">{{ $transaksi['jumlah'] }}</td>
                    <td style="padding: 12px; text-align: right; color: #2c3e50;">Rp {{ number_format($transaksi['total'], 0, ',', '.') }}</td>
                    <td style="padding: 12px; text-align: center; color: #2c3e50;">{{ $transaksi['meja']->nomer_meja ?? 'N/A' }}</td>
                    <td style="padding: 12px; text-align: center; color: #7f8c8d; font-size: 0.85rem;">{{ $transaksi['tanggal']->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background: #FAF9EE; font-weight: 600;">
                    <td colspan="2" style="padding: 12px; color: #2c3e50;">TOTAL</td>
                    <td style="padding: 12px; text-align: right; color: #2c3e50;">Rp {{ number_format($groupedData['total_semua'], 0, ',', '.') }}</td>
                    <td colspan="2" style="padding: 12px; text-align: center; color: #2c3e50;">
                        <div style="margin-bottom: 4px;">Bayar: Rp {{ number_format($groupedData['bayar_semua'], 0, ',', '.') }}</div>
                        <div style="margin-bottom: 4px; color: #065F46;">Kembalian: Rp {{ number_format($groupedData['kembalian_semua'], 0, ',', '.') }}</div>
                        <div style="font-size: 0.95rem; color: #2c3e50;">Kasir: {{ $groupedData['kasir']->name ?? $groupedData['kasir']->username ?? 'N/A' }}</div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div style="margin-top: 30px; text-align: center;">
        <a href="{{ route('laporan.index') }}" style="background: #E0E0E0; color: #2c3e50; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Laporan
        </a>
    </div>
</div>
@endsection

