<?php

namespace SiAtmo;

use Illuminate\Database\Eloquent\Model;

class Pasangan extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'pasangan';
    protected $primaryKey = 'idPasangan';
    protected $fillable = [
        'kodeSparepart', 'kodeKendaraan'
    ];
    public function pasangan_kendaraan(){
        return $this->belongsTo('SiAtmo\Kendaraan');
    }

    public function pasangan_sparepart(){
        return $this->belongsTo('SiAtmo\Sparepart');
    }
}
