<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetilTransaksiServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detilTransaksiService', function (Blueprint $table) {
            $table->increments('idDetilService');
            $table->double('biayaServiceTransaksi');
            $table->string('platNomorKendaraan');
            $table->string('emailPegawai');
            $table->string('kodeNota');
            $table->integer('kodeService');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detilTransaksiServices');
    }
}
