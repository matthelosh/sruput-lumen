<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrakerlapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prakerlaps', function (Blueprint $table) {
            $table->increments('_id');
            $table->string('kode_pkl');
            $table->string('_siswa');
            $table->string('_guru');
            $table->string('_dudi');
            $table->string('periode');
            $table->string('status');
            $table->string('mutasi');
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
        Schema::dropIfExists('prakerlaps');
    }
}
