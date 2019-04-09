<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetilTransaksiSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detilTransaksiSparepart', function (Blueprint $table) {
            $table->increments('idDetilSparepart');
            $table->integer('jumlahSparepart');
            $table->double('hargaJualTransaksi');
            $table->string('kodeNota');
            $table->string('kodeSparepart');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detilTransaksiSpareparts');
    }
}
