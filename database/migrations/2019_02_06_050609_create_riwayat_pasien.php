<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiwayatPasien extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('riwayat_pasien', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pasien_id');
            $table->string('diagnosa_sakit');
            $table->date('tanggal_dirawat');
            $table->integer('lama_rawat');
            $table->string('tindakan');
            $table->text('obat');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('riwayat_pasien');
    }
}
