<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetilPemesanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detilPemesanan', function (Blueprint $table) {
            $table->increments('idDetilPemesanan');
            $table->integer('jumlahPemesanan');
            $table->string('satuan');
            $table->integer('noPemesanan');
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
        Schema::dropIfExists('detilPemesanan');
    }
}
