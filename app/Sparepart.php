<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'sparepart';
    protected $hidden = ['gambarSparepart'];
    protected $primaryKey = 'kodeSparepart';
    public $incrementing = false;
    protected $fillable = [
        'namaSparepart','kodeSparepart', 'tipeSparepart', 'merkSparepart', 'hargaBeli', 
        'hargaJual', 'tempatPeletakan', 'jumlahStok', 'gambarSparepart'
    ];
    public function sparepart_pemesanan() {
        return $this->hasMany('App\DetilPemesanan', 'kodeSparepart');
    }

    public function sparepart_detilTransaksiSparepart() {
        return $this->hasMany('App\DetilTransaksiSparepart', 'kodeSparepart');
    }

    public function sparepart_pasangan() {
        return $this->hasMany('App\Pasangan', 'kodeSparepart');
    }
}
