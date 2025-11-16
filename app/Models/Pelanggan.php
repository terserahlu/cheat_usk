<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'namapelanggan',
        'jeniskelamin',
        'nohp',
        'alamat',
    ];

    public function orderan(){
        return $this->hasOne(Orderan::class, 'idpelaggan');
    }
}
