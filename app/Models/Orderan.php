<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderan extends Model
{
    protected $fillable = [
        'idwaiter',
        'idmenu',
        'idpelaggan',
        'idmeja',
        'jumlah',
    ];

    public function menu(){
        return $this->belongsTo(Menu::class, 'idmenu');
    }

    public function pelanggan(){
        return $this->belongsTo(Pelanggan::class, 'idpelaggan');
    }

    public function meja(){
        return $this->belongsTo(Meja::class, 'idmeja');
    }

    public function waiter(){
        return $this->belongsTo(User::class, 'idwaiter');
    }

    public function transaksi(){
        return $this->hasOne(Transaksi::class, 'idorderan');
    }
}
