<?php

namespace SiAtmo;

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
        return $this->hasMany('SiAtmo\DetilPemesanan', 'kodeSparepart');
    }

    public function sparepart_history() {
        return $this->hasMany('SiAtmo\HistoriSparepart', 'kodeSparepart');
    }

    public function sparepart_detilTransaksiSparepart() {
        return $this->hasMany('SiAtmo\DetilTransaksiSparepart', 'kodeSparepart');
    }

    public function sparepart_pasangan() {
        return $this->hasMany('SiAtmo\Pasangan', 'kodeSparepart');
    }
}
