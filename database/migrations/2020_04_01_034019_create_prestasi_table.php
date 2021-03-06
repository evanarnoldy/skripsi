<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_id');
            $table->string('ipa');
            $table->string('matematika');
            $table->string('bhsind');
            $table->string('bhsing');
            $table->string('rata');
            $table->string('bulan');
            $table->string('tahun');
            $table->string('kesimpulan');
            $table->string('keterangan');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestasi');
    }
}
