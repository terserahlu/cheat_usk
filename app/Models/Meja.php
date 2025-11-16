<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    const STATUS_TERSEDIA = 'tersedia';
    const STATUS_DIISI = 'terisi';
    protected $fillable = [
        'nomer_meja',
        'status',
        'kursi',
    ];

    public function tersedia(): bool
    {
        return $this->status === self::STATUS_TERSEDIA;
    }
    
    public function terisi(): bool
    {
        return $this->status === self::STATUS_DIISI;
    }

    public function orderan(){
        return $this->hasMany(Orderan::class, 'idmeja');
    }
}
