<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSparepartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sparepart', function (Blueprint $table) {
            $table->string('kodeSparepart');
            $table->string('namaSparepart');
            $table->string('tipeSparepart');
            $table->string('merkSparepart');
            $table->double('hargaBeli');
            $table->double('hargaJual');
            $table->string('tempatPeletakan');
            $table->integer('jumlahStok');
            $table->binary('gambarSparepart');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sparepart');
    }
}
