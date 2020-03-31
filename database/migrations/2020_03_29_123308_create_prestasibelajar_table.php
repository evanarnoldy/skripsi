<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestasibelajarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestasibelajar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_id');
            $table->string('uts_biologi');
            $table->string('uts_kimia');
            $table->string('uts_matematika');
            $table->string('uts_bhsind');
            $table->string('uts_bhsing');
            $table->string('uas_biologi');
            $table->string('uas_kimia');
            $table->string('uas_matematika');
            $table->string('uas_bhsind');
            $table->string('uas_bhsing');
            $table->string('rata');
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
        Schema::dropIfExists('prestasibelajar');
    }
}
