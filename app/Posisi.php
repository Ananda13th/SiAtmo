<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posisi extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $table = 'posisi';
    protected $primaryKey = 'idPosisi';
    protected $fillable = [
        'keteranganPosisi'
    ];

    public function user_posisi() {
        return $this->hasMany('App\User', 'idPosisi');
    }
}
