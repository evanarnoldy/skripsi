<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKorelasikelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('korelasikelas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('korelasi');
            $table->string('bulan');
            $table->string('semester');
            $table->string('kelas');
            $table->string('unit');
            $table->string('tahun');
            $table->string('ket');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('korelasikelas');
    }
}
