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
            $table->decimal('pembayaran_spp', 15, 2)->nullable();
            $table->decimal('uang_saku', 15, 2)->nullable();
            $table->decimal('uang_kegiatan', 15, 2)->nullable();
            $table->decimal('uang_spi', 15, 2)->nullable();
            $table->decimal('uang_haul_maulid', 15, 2)->nullable();
            $table->decimal('uang_khidmah_infaq', 15, 2)->nullable();
            $table->decimal('uang_zakat', 15, 2)->nullable();
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
