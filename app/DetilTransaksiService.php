<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetilTransaksiService extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'detiltransaksiservice';
    protected $primaryKey = 'idDetilService';
    public $incrementing = false;
    protected $fillable = [
        'biayaServiceTransaksi', 'platNomorKendaraan', 'emailPegawai', 'kodeNota', 'kodeService'
    ];
    public function detilService_service(){
        return $this->belongsTo('App\Service');
    }

    public function detilService_kosumen(){
        return $this->belongsTo('App\KendaraanKonsumen');
    }

    public function detilService_montir(){
        return $this->belongsTo('App\User');
    }

    public function detilService_transaksi(){
        return $this->belongsTo('App\TransaksiPenjualan');
    }
}
