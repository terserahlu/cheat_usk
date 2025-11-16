<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menu = Menu::all();
        return view('menu.index',compact('menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'namamenu' => 'required|string|min:3',
            'harga' => 'required|numeric|min_digits:3',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try{
            DB::Transaction(function() use($request){
                $menu = Menu::create([
                    'namamenu' => $request->namamenu,
                    'harga' => $request->harga,
                ]);
            });
        }catch(Exception $e){
            return redirect()->back()->with('failed', $e->getMessage())->withInput();
        }

        return redirect()->route('menu.index')->with('success','Data Menu Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = Menu::find($id);
        if(!$menu){
            return redirect()->back()->with('Failed', 'Data Menu Tidak Ditemukan');
        }
        return view('menu.show',compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $menu = Menu::find($id);
        if(!$menu){
            return redirect()->back()->with('Failed', 'Data Menu Tidak Ditemukan');
        }
        return view('menu.edit',compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $menu = Menu::find($id);
        if(!$menu){
            return redirect()->back()->with('Failed', 'Data Menu Tidak Ditemukan');
        }

        $validate = Validator::make($request->all(),[
            'namamenu' => 'required|string|min:3',
            'harga' => 'required|numeric|min_digits:3',
        ]);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try{
            DB::Transaction(function() use($request, $menu){
                $menu->update([
                    'namamenu' => $request->namamenu,
                    'harga' => $request->harga,
                ]);
            });
        }catch(Exception $e){
            return redirect()->back()->with('failed', 'Data Menu Gagal Diperbarui:' .$e->getMessage())->withInput();
        }

        return redirect()->route('menu.index')->with('success', 'Data Menu Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $menu = Menu::find($id);
        if(!$menu){
            return redirect()->back()->with('Failed', 'Data Menu Tidak Ditemukan');
        }

        try {
            DB::Transaction(function() use ($menu) {
                $menu->delete();
            });
            return redirect()->route('menu.index')->with('success', 'Data Menu Berhasil Dihapus');
        } catch (Exception $e) {
            return redirect()->back()->with('failed', 'Data Menu Gagal Dihapus: ' . $e->getMessage());
        }
    }
}
