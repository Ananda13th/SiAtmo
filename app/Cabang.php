<?php

namespace SiAtmo;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'cabang';
    protected $primaryKey = 'idCabang';
    protected $fillable = [
        'namaCabang', 'alamat'
    ];

    public function user_cabang() {
        return $this->hasMany('SiAtmo\User', 'idCabang');
    }
}
