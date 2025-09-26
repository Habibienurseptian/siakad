<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengumuman_terbaru', function (Blueprint $table) {
            $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');
        });
        Schema::table('pengumuman_akademik', function (Blueprint $table) {
            $table->unsignedBigInteger('sekolah_id')->nullable()->after('id');
        });
    }

    public function down()
    {
        Schema::table('pengumuman_terbaru', function (Blueprint $table) {
            $table->dropColumn('sekolah_id');
        });
        Schema::table('pengumuman_akademik', function (Blueprint $table) {
            $table->dropColumn('sekolah_id');
        });
    }
};
