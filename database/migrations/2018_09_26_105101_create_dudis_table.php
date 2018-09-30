<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDudisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dudis', function (Blueprint $table) {
            $table->string('kode_dudi');
            $table->string('nama_dudi');
            $table->string('alamat');
            $table->string('kota');
            $table->string('pemilik');
            $table->string('telp');
            $table->string('email');
            $table->string('kuota');
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
        Schema::table('dudis', function (Blueprint $table) {
            //
        });
    }
}
