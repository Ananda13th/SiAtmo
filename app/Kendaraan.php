<?php

namespace SiAtmo;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'kendaraan';
    protected $primaryKey = 'kodeKendaraan';
    protected $fillable = [
        'merkKendaraan', 'tipeKendaraan'
    ];
    public function kendaraan_pasangan() {
        return $this->hasMany('SiAtmo\Pasangan', 'kodeKendaraan');
    }

    public function kedaraan_konsumen() {
        return $this->hasMany('SiAtmo\KendaraanKonsumen', 'kodeKendaraan');
    }
}
