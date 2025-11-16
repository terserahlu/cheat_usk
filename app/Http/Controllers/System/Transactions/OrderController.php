<?php

namespace App\Http\Controllers\System\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use App\Models\Orderan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orderans = \App\Models\Orderan::with(['menu', 'pelanggan', 'meja', 'waiter', 'transaksi'])
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedOrderans = $orderans->groupBy(function ($orderan) {
            return $orderan->idpelaggan;
        })->map(function ($group) {
            $firstOrderan = $group->first();
            $pelanggan = $firstOrderan->pelanggan;
            
            return [
                'id_pelanggan' => $pelanggan->id ?? null,
                'pelanggan' => $pelanggan,
                'orderans' => $group->map(function ($orderan) {
                    return [
                        'id' => $orderan->id,
                        'menu' => $orderan->menu,
                        'jumlah' => $orderan->jumlah,
                        'meja' => $orderan->meja,
                        'waiter' => $orderan->waiter,
                        'subtotal' => ($orderan->menu->harga ?? 0) * $orderan->jumlah,
                        'transaksi' => $orderan->transaksi,
                        'tanggal' => $orderan->created_at,
                    ];
                }),
                'total_semua' => $group->sum(function ($orderan) {
                    return ($orderan->menu->harga ?? 0) * $orderan->jumlah;
                }),
            ];
        })->values();

        return view('orderan.index', compact('groupedOrderans'));
    }

    public function order(Request $request)
    {
        if ($request->has('orders') && is_array($request->orders)) {
            $validator = Validator::make($request->all(), [
                'namapelanggan' => 'required|string|min:3',
                'jeniskelamin'  => 'required|boolean',
                'nohp'          => 'nullable|digits_between:10,15',
                'alamat'        => 'nullable|string',
                'id_meja'       => 'required|exists:mejas,id',
                'orders'        => 'required|array|min:1',
                'orders.*.id_menu'  => 'required|exists:menus,id',
                'orders.*.jumlah'   => 'nullable|integer|min:1',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use ($request) {
                $pelanggan = Pelanggan::create([
                    'namapelanggan' => $request->namapelanggan,
                    'jeniskelamin'  => $request->jeniskelamin,
                    'nohp'          => $request->nohp,
                    'alamat'        => $request->alamat,
                ]);

                $idPelanggan = $pelanggan->id;

                foreach ($request->orders as $item) {
                    Orderan::create([
                        'idmenu'      => $item['id_menu'],
                        'idmeja'      => $request->id_meja,
                        'idpelaggan'  => $idPelanggan,
                        'jumlah'      => $item['jumlah'] ?? 1,
                        'idwaiter'    => Auth::user()->id,
                    ]);
                }

                if (DB::getDriverName() === 'mysql') {
                    DB::statement('CALL update_meja_status_terisi(?)', [$request->id_meja]);
                } else {
                    Meja::where('id', $request->id_meja)->update([
                        'status' => Meja::STATUS_DIISI
                    ]);
                }
            });

            return redirect()->route('orderan.index')->with('success','Pesanan berhasil dibuat');
        }

        $validator = Validator::make($request->all(), [
            'namapelanggan' => 'required|string|min:3',
            'jeniskelamin'  => 'required|boolean',
            'nohp'          => 'nullable|digits_between:10,15',
            'alamat'        => 'nullable|string',
            'id_meja'       => 'required|exists:mejas,id',
            'id_menu'       => 'required|exists:menus,id',
            'jumlah'        => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        DB::transaction(function() use ($request) {
            $pelanggan = Pelanggan::create([
                'namapelanggan' => $request->namapelanggan,
                'jeniskelamin'  => $request->jeniskelamin,
                'nohp'          => $request->nohp,
                'alamat'        => $request->alamat,
            ]);

            $idPelanggan = $pelanggan->id;

            Orderan::create([
                'idmenu'      => $request->id_menu,
                'idmeja'      => $request->id_meja,
                'idpelaggan'  => $idPelanggan,
                'jumlah'      => $request->jumlah ?? 1,
                'idwaiter'    => Auth::user()->id,
            ]);

            Meja::where('id', $request->id_meja)->update([
                'status' => Meja::STATUS_DIISI
            ]);
        });

        return redirect()->route('orderan.index')->with('success','Pesanan berhasil dibuat');
    }
}
