<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbsensiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensi_detail', function (Blueprint $table) {
            $table->id();
            $table->string('id_absensi', 15);
            $table->string('nisn');
            $table->tinyInteger('status'); //1 hadir //2 sakit //3 izin //4 alpa  
            $table->text('keterangan')->nullable();
            $table->string('gambar')->nullable();
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
        Schema::dropIfExists('absensi_detail');
    }
}
