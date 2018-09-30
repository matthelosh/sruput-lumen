<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePraktikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('praktikans', function (Blueprint $table) {
            $table->increments('_id');
            $table->string('uname');
            $table->string('password');
            $table->string('api_token');
            $table->string('nis');
            $table->string('nama');
            $table->string('kelas');
            $table->string('periode');
            $table->string('hp');
            $table->string('hp_ortu');
            $table->string('alamat');
            $table->string('_role');
            $table->string('isActive');

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
        Schema::dropIfExists('praktikans');
    }
}
