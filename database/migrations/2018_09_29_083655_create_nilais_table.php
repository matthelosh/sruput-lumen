<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_nilai');
            $table->string('_siswa');
            $table->string('_dudi');
            $table->string('periode');
            $table->float('nt1');
            $table->float('nt2');
            $table->float('nt3');
            $table->float('nt4');
            $table->float('nt5');
            $table->float('nt6');
            $table->float('nt7');
            $table->float('nt8');
            $table->float('t1');
            $table->float('t2');
            $table->float('t3');
            $table->float('t4');
            $table->float('t5');
            $table->float('t6');
            $table->float('t7');
            $table->float('t8');
            $table->float('t9');
            $table->float('t10');
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
        Schema::dropIfExists('nilais');
    }
}
