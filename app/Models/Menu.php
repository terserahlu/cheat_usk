<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'namamenu',
        'harga',
    ];

    public function orderan(){
        return $this->hasMany(Orderan::class,'idmenu');
    }
}
