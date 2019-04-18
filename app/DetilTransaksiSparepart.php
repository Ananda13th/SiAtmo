<?php

namespace SiAtmo;

use Illuminate\Database\Eloquent\Model;


class DetilTransaksiSparepart extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'detiltransaksisparepart';
    protected $primaryKey = 'idDetilSparepart';
    public $incrementing = false;
    protected $fillable = [
        'hargaJualTransaksi', 'jumlahSparepart','kodeNota', 'kodeSparepart'
    ];
    public function detilSparepart_transaksi(){
        return $this->belongsTo('SiAtmo\TransaksiPenjualan');
    }

    public function detilSparepart_sparepart(){
        return $this->belongsTo('SiAtmo\Sparepart');
    }
}
