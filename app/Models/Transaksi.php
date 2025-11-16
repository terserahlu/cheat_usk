<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'idkasir',
        'idorderan',
        'total',
        'bayar',
    ];
    
    public function kasir(){
        return $this->belongsTo(User::class, 'idkasir');
    }

    public function orderan(){
        return $this->belongsTo(Orderan::class, 'idorderan');
    }

    public function pelanggan(){
        return $this->hasOneThrough(Pelanggan::class,Orderan::class,'id','id','idorderan','idpelanggan');
    }
    public function menu(){
        return $this->hasOneThrough(Menu::class,Orderan::class,'id','id','idorderan','idmenu');
    }

    public function meja(){
        return $this->hasOneThrough(Meja::class,Orderan::class,'id','id','idorderan','idmeja');
    }

    public function waiter(){
        return $this->hasOneThrough(User::class,Orderan::class,'id','id','idorderan','idwaiter');
    }
}
