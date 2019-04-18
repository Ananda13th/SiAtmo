<?php

namespace SiAtmo;

use Illuminate\Database\Eloquent\Model;

class PegawaiOnDuty extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'pegawaionduty';
    protected $primaryKey = 'idDuty';
    protected $fillable = [
       'email', 'kodeNota'
    ];

    public function onDuty_transaksi(){
        return $this->belongsTo('SiAtmo\TransaksiPenjualan');
    }

    public function onDuty_pegawai(){
        return $this->belongsTo('SiAtmo\User');
    }
}
