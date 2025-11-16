<?php

namespace App\Http\Controllers\System\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['orderan.pelanggan', 'orderan.menu', 'kasir', 'orderan.meja'])
            ->get();

        $groupedTransaksis = $transaksis->groupBy(function ($transaksi) {
            return $transaksi->orderan->idpelaggan;
        })->map(function ($group) {
            $firstTransaksi = $group->first();
            $pelanggan = $firstTransaksi->orderan->pelanggan;
            
            $firstKasir = $group->first()->kasir;
            
            return [
                'id_pelanggan' => $pelanggan->id ?? null,
                'pelanggan' => $pelanggan,
                'transaksis' => $group->map(function ($transaksi) {
                    return [
                        'id' => $transaksi->id,
                        'kasir' => $transaksi->kasir,
                        'menu' => $transaksi->orderan->menu,
                        'jumlah' => $transaksi->orderan->jumlah,
                        'total' => $transaksi->total,
                        'bayar' => $transaksi->bayar,
                        'kembalian' => $transaksi->bayar - $transaksi->total,
                        'meja' => $transaksi->orderan->meja,
                        'tanggal' => $transaksi->created_at,
                    ];
                }),
                'total_semua' => $group->sum('total'),
                'bayar_semua' => $group->sum('bayar'),
                'kembalian_semua' => $group->sum('bayar') - $group->sum('total'),
                'kasir' => $firstKasir,
            ];
        })->values();

        return view('laporan.index', compact('groupedTransaksis'));
    }

    public function show($idPelanggan)
    {
        $transaksis = Transaksi::with(['orderan.pelanggan', 'orderan.menu', 'kasir', 'orderan.meja'])
            ->whereHas('orderan', function ($query) use ($idPelanggan) {
                $query->where('idpelaggan', $idPelanggan);
            })
            ->get();

        if ($transaksis->isEmpty()) {
            return back()->withErrors(['error' => 'Transaksi tidak ditemukan']);
        }

        $firstTransaksi = $transaksis->first();
        $pelanggan = $firstTransaksi->orderan->pelanggan;

        $firstKasir = $transaksis->first()->kasir;
        
        $groupedData = [
            'id_pelanggan' => $pelanggan->id ?? null,
            'pelanggan' => $pelanggan,
            'transaksis' => $transaksis->map(function ($transaksi) {
                return [
                    'id' => $transaksi->id,
                    'kasir' => $transaksi->kasir,
                    'menu' => $transaksi->orderan->menu,
                    'jumlah' => $transaksi->orderan->jumlah,
                    'total' => $transaksi->total,
                    'bayar' => $transaksi->bayar,
                    'kembalian' => $transaksi->bayar - $transaksi->total,
                    'meja' => $transaksi->orderan->meja,
                    'tanggal' => $transaksi->created_at,
                ];
            }),
            'total_semua' => $transaksis->sum('total'),
            'bayar_semua' => $transaksis->sum('bayar'),
            'kembalian_semua' => $transaksis->sum('bayar') - $transaksis->sum('total'),
            'kasir' => $firstKasir,
        ];

        return view('laporan.show', compact('groupedData'));
    }

    public function downloadPDF()
    {
        $transaksis = Transaksi::with(['orderan.pelanggan', 'orderan.menu', 'kasir', 'orderan.meja'])
            ->get();

        $groupedTransaksis = $transaksis->groupBy(function ($transaksi) {
            return $transaksi->orderan->idpelaggan;
        })->map(function ($group) {
            $firstTransaksi = $group->first();
            $pelanggan = $firstTransaksi->orderan->pelanggan;
            
            $firstKasir = $group->first()->kasir;
            
            return [
                'id_pelanggan' => $pelanggan->id ?? null,
                'pelanggan' => $pelanggan,
                'transaksis' => $group->map(function ($transaksi) {
                    return [
                        'id' => $transaksi->id,
                        'kasir' => $transaksi->kasir,
                        'menu' => $transaksi->orderan->menu,
                        'jumlah' => $transaksi->orderan->jumlah,
                        'total' => $transaksi->total,
                        'bayar' => $transaksi->bayar,
                        'kembalian' => $transaksi->bayar - $transaksi->total,
                        'meja' => $transaksi->orderan->meja,
                        'tanggal' => $transaksi->created_at,
                    ];
                }),
                'total_semua' => $group->sum('total'),
                'bayar_semua' => $group->sum('bayar'),
                'kembalian_semua' => $group->sum('bayar') - $group->sum('total'),
                'kasir' => $firstKasir,
            ];
        })->values();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', compact('groupedTransaksis'));
        
        return $pdf->download('laporan-semua-transaksi-' . date('Y-m-d') . '.pdf');
    }

    public function downloadPDFSingle($idPelanggan)
    {
        $transaksis = Transaksi::with(['orderan.pelanggan', 'orderan.menu', 'kasir', 'orderan.meja'])
            ->whereHas('orderan', function ($query) use ($idPelanggan) {
                $query->where('idpelaggan', $idPelanggan);
            })
            ->get();

        if ($transaksis->isEmpty()) {
            return back()->withErrors(['error' => 'Transaksi tidak ditemukan']);
        }

        $firstTransaksi = $transaksis->first();
        $pelanggan = $firstTransaksi->orderan->pelanggan;

        $firstKasir = $transaksis->first()->kasir;
        
        $groupedData = [
            'id_pelanggan' => $pelanggan->id ?? null,
            'pelanggan' => $pelanggan,
            'transaksis' => $transaksis->map(function ($transaksi) {
                return [
                    'id' => $transaksi->id,
                    'kasir' => $transaksi->kasir,
                    'menu' => $transaksi->orderan->menu,
                    'jumlah' => $transaksi->orderan->jumlah,
                    'total' => $transaksi->total,
                    'bayar' => $transaksi->bayar,
                    'kembalian' => $transaksi->bayar - $transaksi->total,
                    'meja' => $transaksi->orderan->meja,
                    'tanggal' => $transaksi->created_at,
                ];
            }),
            'total_semua' => $transaksis->sum('total'),
            'bayar_semua' => $transaksis->sum('bayar'),
            'kembalian_semua' => $transaksis->sum('bayar') - $transaksis->sum('total'),
            'kasir' => $firstKasir,
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf-single', compact('groupedData'));
        
        $namaPelanggan = $pelanggan->namapelanggan ?? 'pelanggan';
        $namaFile = 'laporan-' . str_replace(' ', '-', strtolower($namaPelanggan)) . '-' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($namaFile);
    }
}
