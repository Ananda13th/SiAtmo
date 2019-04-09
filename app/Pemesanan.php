<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'pemesanan';
    protected $primaryKey = 'noPemesanan';
    protected $fillable = [
        'tanggalPemesanan','statusPemesanan', 'namaPerusahaan'
    ];

    public function detil_pesan() {
        return $this->hasMany('App\DetilPemesanan', 'noPemesanan');
    }

    public function pemesanan_supplier(){
        return $this->belongsTo('App\Supplier');
    }
}
