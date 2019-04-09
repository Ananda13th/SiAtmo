<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiPenjualansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksiPenjualan', function (Blueprint $table) {
            $table->string('kodeNota');
            $table->date('tanggalTransaksi');
            $table->date('tanggalLunas');
            $table->double('subtotal');
            $table->double('diskon');
            $table->double('total');
            $table->string('statusTransaksi');
            $table->string('namaKonsumen');
            $table->string('noTelpKonsumen');
            $table->string('alamatKonsumen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksiPenjualans');
    }
}
