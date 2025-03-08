<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaporansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelaporan', function (Blueprint $table) {
            $table->id('id_pelaporan');
            $table->dateTime('tgl_pelaporan');
            $table->string('nama_karyawan');
            $table->integer('id_karyawan');
            $table->string('status_karyawan');
            $table->string('departemen');
            $table->string('kategori_bahaya');
            $table->text('isi_laporan');
            $table->dateTime('tgl_kejadian');
            $table->text('lokasi_kejadian');
            $table->string('foto');
            $table->enum('status', ['pending', 'proses', 'selesai', 'terhapus']);

            $table->softDeletes();
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
        Schema::dropIfExists('pelaporan');
    }
}