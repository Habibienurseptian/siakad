<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('warga_negara')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kode_pos')->nullable();
            $table->string('tempat_lahir_orangtua')->nullable();
            $table->date('tanggal_lahir_orangtua')->nullable();
            $table->enum('status_marital', ['menikah', 'belum menikah', 'cerai'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            $table->dropColumn([
                'tempat_lahir',
                'tanggal_lahir',
                'warga_negara',
                'alamat',
                'kode_pos',
                'tempat_lahir_orangtua',
                'tanggal_lahir_orangtua',
                'status_marital',
            ]);
        });
    }
};
