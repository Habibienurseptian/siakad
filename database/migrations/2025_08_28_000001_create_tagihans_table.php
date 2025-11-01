<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('murid_id');
            
            $table->decimal('spp', 15, 2)->nullable();
            $table->decimal('spi', 15, 2)->nullable();
            $table->decimal('tagihan_kegiatan', 15, 2)->nullable();
            $table->decimal('tagihan_semester_ganjil', 15, 2)->nullable();
            $table->decimal('tagihan_semester_genap', 15, 2)->nullable();
            $table->decimal('haul', 15, 2)->nullable();

            $table->enum('status', ['lunas', 'belum_lunas'])->default('belum_lunas');
            $table->string('periode');

            $table->timestamps();

            $table->foreign('murid_id')->references('id')->on('murids')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihans');
    }
};
