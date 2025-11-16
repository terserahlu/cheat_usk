<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Meja;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MejaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meja = Meja::all();
        return view('meja.index',compact('meja'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('meja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'nomer_meja' => 'required|unique:mejas,nomer_meja',
            'kursi' => 'required|in:2,4,8',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try{
            DB::Transaction(function() use($request){
                $meja = Meja::create([
                    'nomer_meja' => $request->nomer_meja,
                    'kursi' => $request->kursi,
                    'status' => Meja::STATUS_TERSEDIA
                ]);
            });
        }catch(Exception $e){
            return redirect()->back()->with('failed', $e->getMessage())->withInput();
        }

        return redirect()->route('meja.index')->with('success','Data Meja Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meja = Meja::find($id);
        if(!$meja){
            return redirect()->back()->with('failed', 'Data Meja Tidak Ditemukan');
        }
        return view('meja.show',compact('meja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $meja = Meja::find($id);
        if(!$meja){
            return redirect()->back()->with('failed', 'Data Meja Tidak Ditemukan');
        }
        
        if($meja->status == Meja::STATUS_DIISI){
            return redirect()->back()->with('failed', 'Meja Sedang Terisi, Data Tidak Dapat Diubah');
        }
        return view('meja.edit',compact('meja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $meja = Meja::find($id);
        if(!$meja){
            return redirect()->back()->with('failed', 'Data Meja Tidak Ditemukan');
        }
        
        if($meja->status == Meja::STATUS_DIISI){
            return redirect()->back()->with('failed', 'Meja Sedang Terisi, Data Tidak Dapat Diubah');
        }

        $validate = Validator::make($request->all(),[
            'nomer_meja' => 'required|unique:mejas,nomer_meja,'.$id,
            'kursi' => 'required|in:2,4,8',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try{
            DB::Transaction(function() use($request, $meja){
                $meja->update([
                    'nomer_meja' => $request->nomer_meja,
                    'kursi' => $request->kursi,
                    'status' => Meja::STATUS_TERSEDIA
                ]);
            });
        }catch(Exception $e){
            return redirect()->back()->with('failed', 'Data Meja Gagal Diperbarui:' .$e->getMessage())->withInput();
        }

        return redirect()->route('meja.index')->with('success', 'Data Meja Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $meja = Meja::find($id);
        if(!$meja){
            return redirect()->back()->with('failed', 'Data Meja Tidak Ditemukan');
        }
        
        if($meja->status == Meja::STATUS_DIISI){
            return redirect()->back()->with('failed', 'Meja Sedang Terisi, Data Tidak Dapat Dihapus');
        }

        try {
            DB::Transaction(function() use ($meja) {
                $meja->delete();
            });
            return redirect()->route('meja.index')->with('success', 'Data Meja Berhasil Dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('failed', 'Data Meja Gagal Dihapus: ' . $e->getMessage());
        }
    }
}
