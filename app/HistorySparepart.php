<?php

namespace SiAtmo;

use Illuminate\Database\Eloquent\Model;

class HistorySparepart extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'historisparepart';
    protected $fillable = [
        'kodeSparepart', 'tanggal','jumlah'
    ];

    public function history_sparepart() {
        return $this->belongsTo('SiAtmo\Sparepart');
    }
}
