<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    public $incrementing = false;
    protected $table = 'supplier';
    protected $primaryKey = 'namaPerusahaan';
    protected $fillable = [
        'namaPerusahaan', 'alamatSupplier', 'namaSales', 'noTelpSales'
    ];
    public function supplier_pemesanan(){
        return $this->hasMany('App\Pemesanan', 'namaPerusahaan');
    }
}
