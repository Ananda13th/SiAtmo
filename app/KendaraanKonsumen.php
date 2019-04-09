<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KendaraanKonsumen extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'kendaraankonsumen';
    protected $primaryKey = 'platNomorKendaraan';
    public $incrementing = false;
    protected $fillable = [
        'kodeKendaraan'
    ];

    public function konsumen_kendaraan(){
        return $this->belongsTo('App\Kendaraan');
    }

    public function konsumen_transaksi(){
        return $this->hasMany('App\DetilTransaksiKendaraan', 'platNomorKendaraan');
    }
}
