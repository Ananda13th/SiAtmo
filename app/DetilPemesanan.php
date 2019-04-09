<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetilPemesanan extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'detilpemesanan';
    protected $primaryKey = 'idDetilPemesanan';
    protected $fillable = [
        'noPemesanan', 'jumlahPemesanan', 'satuan', 'kodeSparepart' 
    ];

    public function pemesanan(){
        return $this->belongsTo('App\Pemesanan');
    }

    public function sparepart() {
        return $this->belongsTo('App\Sparepart');
    }

}
