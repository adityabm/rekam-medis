<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableRiwayat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('riwayat_pasien', function (Blueprint $table) {
            $table->date('tanggal_dirawat')->nullbale()->change();
            $table->integer('lama_rawat')->nullbale()->change();
            $table->string('tindakan')->nullbale()->change();
            $table->text('obat')->nullbale()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
