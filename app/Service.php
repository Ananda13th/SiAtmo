<?php

namespace SiAtmo;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'service';
    protected $primaryKey = 'kodeService';
    protected $fillable = [
        'keterangan','biayaService'
    ];

    public function service_detilTransaksiService() {
        return $this->hasMany('SiAtmo\DetilTransaksiService', 'kodeService');
    }
}
