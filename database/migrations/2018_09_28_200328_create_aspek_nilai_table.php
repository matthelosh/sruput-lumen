<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAspekNilaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aspeknilais', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_aspek');
            $table->string('aspek');
            $table->string('text');
            $table->string('progli');
            $table->string('isActive')->default('1');
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
        Schema::table('aspeknilais', function (Blueprint $table) {
            //
        });
    }
}
