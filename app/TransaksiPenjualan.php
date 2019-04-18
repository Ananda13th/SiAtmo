<?php

namespace SiAtmo;

use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'transaksipenjualan';
    protected $primaryKey = 'kodeNota';
    public $incrementing = false;
    protected $fillable = [
        'kodeNota', 'tanggalTransaksi', 'tanggalLunas', 'subtotal', 'diskon', 'total', 
        'statusTransaksi', 'namaKonsumen', 'noTelpKonsumen', 'alamatKonsumen'
    ];
    public function transaksi_service(){
        return $this->hasMany('SiAtmo\DetilTransaksiService', 'kodeNota');
    }

    public function transaksi_sparepart(){
        return $this->hasMany('SiAtmo\DetilTransaksiSparepart', 'kodeNota');
    }

    public function transaksi_onDuty(){
        return $this->hasMany('SiAtmo\PegawaiOnDuty', 'kodeNota');
    }
}
