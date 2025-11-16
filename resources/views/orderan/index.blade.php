@extends('layouts.app')
@section('title', 'Data Orderan')
@section('content')
<div class="page-header">
    <h2>Data Orderan</h2>
    <p>Kelola data pesanan pelanggan</p>
</div>

@if(session('success'))
    <div class="alert alert-success" style="background: #D1FAE5; border: 1px solid #6EE7B7; color: #065F46; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('success') }}
    </div>
@endif

@if(session('failed'))
    <div class="alert alert-danger" style="background: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
        {{ session('failed') }}
    </div>
@endif

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <a href="{{ route('orderan.create') }}" style="background: #A2AF9B; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-plus"></i> Buat Pesanan
    </a>
</div>

@if($groupedOrderans->count() > 0)
    @foreach($groupedOrderans as $group)
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
                <div style="font-size: 1.1rem; font-weight: 600; color: #A2AF9B;">
                    Total: Rp {{ number_format($group['total_semua'], 0, ',', '.') }}
                </div>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #FAF9EE; border-bottom: 2px solid #D4DED0;">
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Menu</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Jumlah</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Meja</th>
                        <th style="padding: 12px; text-align: left; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Waiter</th>
                        <th style="padding: 12px; text-align: right; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Subtotal</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Status</th>
                        <th style="padding: 12px; text-align: center; font-weight: 600; color: #2c3e50; font-size: 0.9rem;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($group['orderans'] as $orderan)
                    <tr style="border-bottom: 1px solid #EEEEEE;">
                        <td style="padding: 12px; color: #2c3e50;">
                            <div style="font-weight: 600;">{{ $orderan['menu']->namamenu ?? 'N/A' }}</div>
                            <div style="font-size: 0.85rem; color: #7f8c8d;">Rp {{ number_format($orderan['menu']->harga ?? 0, 0, ',', '.') }}</div>
                        </td>
                        <td style="padding: 12px; text-align: center; color: #2c3e50;">{{ $orderan['jumlah'] }}</td>
                        <td style="padding: 12px; color: #2c3e50;">{{ $orderan['meja']->nomer_meja ?? 'N/A' }}</td>
                        <td style="padding: 12px; color: #2c3e50;">{{ $orderan['waiter']->name ?? $orderan['waiter']->username ?? 'N/A' }}</td>
                        <td style="padding: 12px; text-align: right; font-weight: 600; color: #2c3e50;">
                            Rp {{ number_format($orderan['subtotal'], 0, ',', '.') }}
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            @if($orderan['transaksi'])
                                <span style="padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; background: #D1FAE5; color: #065F46;">
                                    Sudah Bayar
                                </span>
                            @else
                                <span style="padding: 6px 12px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; background: #FEE2E2; color: #991B1B;">
                                    Belum Bayar
                                </span>
                            @endif
                        </td>
                        <td style="padding: 12px; text-align: center; color: #7f8c8d; font-size: 0.85rem;">
                            {{ $orderan['tanggal']->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #FAF9EE; font-weight: 600;">
                        <td colspan="4" style="padding: 12px; color: #2c3e50;">TOTAL</td>
                        <td style="padding: 12px; text-align: right; color: #2c3e50;">Rp {{ number_format($group['total_semua'], 0, ',', '.') }}</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endforeach
@else
    <div style="background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 40px; text-align: center;">
        <i class="fa-solid fa-clipboard-list" style="font-size: 48px; margin-bottom: 16px; display: block; opacity: 0.5; color: #7f8c8d;"></i>
        <p style="color: #7f8c8d;">Belum ada data orderan</p>
    </div>
@endif
@endsection

