<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            $table->unsignedBigInteger('sekolah_id')->nullable()->after('user_id');
            $table->foreign('sekolah_id')->references('id')->on('sekolahs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('murids', function (Blueprint $table) {
            $table->dropForeign(['sekolah_id']);
            $table->dropColumn('sekolah_id');
        });
    }
};
