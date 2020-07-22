<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaliKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wali_kelas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('NIP', 9)->unique();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('jenis_kelamin');
            $table->string('alamat');
            $table->string('email')->unique();
            $table->string('kelas_diampu');
            $table->string('unit');
            $table->string('avatar')->default('default.jpg');
            $table->string('role')->default('wali kelas');
            $table->string('password')->default(bcrypt(123456));
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
        Schema::dropIfExists('wali_kelas');
    }
}
