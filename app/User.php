<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'email';
    
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gaji', 'nomorTelpon','idPosisi','idCabang'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function pegawai_posisi(){
        return $this->belongsTo('App\Posisi');
    }

    public function pegawai_cabang(){
        return $this->belongsTo('App\Cabang');
    }

    public function pegawai_onDuty(){
        return $this->hasMany('App\PegawaiOnDuty', 'email');
    }
}
