<?php

namespace SiAtmo;

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
        return $this->belongsTo('SiAtmo\Service');
    }

    public function detilService_kosumen(){
        return $this->belongsTo('SiAtmo\KendaraanKonsumen');
    }

    public function detilService_montir(){
        return $this->belongsTo('SiAtmo\User');
    }

    public function detilService_transaksi(){
        return $this->belongsTo('SiAtmo\TransaksiPenjualan');
    }
}
