<?php

namespace App\Http\Controllers\System\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Orderan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['orderan.pelanggan', 'orderan.menu', 'orderan.meja', 'kasir'])
            ->orderBy('created_at', 'desc')
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
                        'menu' => $transaksi->orderan->menu,
                        'jumlah' => $transaksi->orderan->jumlah,
                        'total' => $transaksi->total,
                        'bayar' => $transaksi->bayar,
                        'kembalian' => $transaksi->bayar - $transaksi->total,
                        'meja' => $transaksi->orderan->meja,
                        'kasir' => $transaksi->kasir,
                        'tanggal' => $transaksi->created_at,
                    ];
                }),
                'total_semua' => $group->sum('total'),
                'bayar_semua' => $group->sum('bayar'),
                'kembalian_semua' => $group->sum(function ($transaksi) {
                    return $transaksi->bayar - $transaksi->total;
                }),
                'kasir' => $firstKasir,
            ];
        })->values();

        return view('transaksi.index', compact('groupedTransaksis'));
    }

    public function transaksi(Request $request)
    {
        if ($request->has('orderans') && is_array($request->orderans)) {
            $validator = Validator::make($request->all(), [
                'orderans'      => 'required|array|min:1',
                'orderans.*'    => 'required|exists:orderans,id',
                'bayar'         => 'required|numeric|min:1',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $total = 0;
            $idMeja = null;
            foreach ($request->orderans as $idOrderan) {
                $orderan = Orderan::with('menu')->findOrFail($idOrderan);
                
                if ($orderan->transaksi) {
                    return back()->withErrors(['orderans' => 'Orderan sudah memiliki transaksi'])->withInput();
                }

                $hargaMenu = $orderan->menu->harga;
                $jumlah = $orderan->jumlah;
                $total += $hargaMenu * $jumlah;

                if ($idMeja === null) {
                    $idMeja = $orderan->idmeja;
                }
            }

            $bayar = (int) $request->bayar;
            if ($bayar < $total) {
                return back()->withErrors(['bayar' => 'Jumlah pembayaran kurang dari total'])->withInput();
            }

            DB::Transaction(function() use ($request, $total, $idMeja, $bayar) {
                $orderansArray = [];
                $totalSebelumnya = 0;

                // Siapkan data orderan terlebih dahulu
                foreach ($request->orderans as $idOrderan) {
                    $orderanItem = Orderan::with('menu')->findOrFail($idOrderan);
                    $hargaMenu = $orderanItem->menu->harga;
                    $jumlah = $orderanItem->jumlah;
                    $subtotal = $hargaMenu * $jumlah;
                    
                    $orderansArray[] = [
                        'id' => $idOrderan,
                        'subtotal' => $subtotal,
                    ];
                }

                // Buat transaksi
                $totalOrderans = count($orderansArray);
                foreach ($orderansArray as $index => $orderanData) {
                    $isLast = ($index === $totalOrderans - 1);
                    
                    if ($isLast) {
                        // Untuk item terakhir, masukkan semua sisa
                        $bayarTransaksi = $bayar - $totalSebelumnya;
                    } else {
                        // Untuk item pertama sampai sebelum terakhir, masukkan harga sesuai list
                        $bayarTransaksi = $orderanData['subtotal'];
                        $totalSebelumnya += $orderanData['subtotal'];
                    }

                    Transaksi::create([
                        'idkasir'   => Auth::user()->id,
                        'idorderan' => $orderanData['id'],
                        'total'     => $orderanData['subtotal'],
                        'bayar'     => $bayarTransaksi,
                    ]);
                }

                if ($idMeja) {
                    // Update status meja menggunakan stored procedure
                    if (DB::getDriverName() === 'mysql') {
                        DB::statement('CALL update_meja_status_tersedia(?)', [$idMeja]);
                    } else {
                        // Fallback untuk database lain (SQLite, dll)
                        Meja::where('id', $idMeja)->update([
                            'status' => Meja::STATUS_TERSEDIA
                        ]);
                    }
                }
            });

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat');
        }

        $validator = Validator::make($request->all(), [
            'id_orderan' => 'required|exists:orderans,id',
            'bayar'     => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $orderan = Orderan::with('menu')->findOrFail($request->id_orderan);

        if ($orderan->transaksi) {
            return back()->withErrors(['id_orderan' => 'Orderan sudah memiliki transaksi'])->withInput();
        }

        $hargaMenu = $orderan->menu->harga;
        $jumlah = $orderan->jumlah;
        $total = $hargaMenu * $jumlah;

        $bayar = (int) $request->bayar;
        if ($bayar < $total) {
            return back()->withErrors(['bayar' => 'Jumlah pembayaran kurang dari total'])->withInput();
        }

        DB::Transaction(function() use ($request, $orderan, $total, $bayar) {

            Transaksi::create([
                'idkasir'   => Auth::user()->id,
                'idorderan' => $request->id_orderan,
                'total'     => $total,
                'bayar'     => $bayar,
            ]);

            // Update status meja menggunakan stored procedure
            if (DB::getDriverName() === 'mysql') {
                DB::statement('CALL update_meja_status_tersedia(?)', [$orderan->idmeja]);
            } else {
                // Fallback untuk database lain (SQLite, dll)
                Meja::where('id', $orderan->idmeja)->update([
                    'status' => Meja::STATUS_TERSEDIA
                ]);
            }
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat');
    }
}
