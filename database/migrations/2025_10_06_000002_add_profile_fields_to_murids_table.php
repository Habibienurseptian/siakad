<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('murids', function (Blueprint $table) {
            $table->string('profile_image')->nullable();
            $table->string('phone')->nullable();
            $table->string('nama_orangtua')->nullable();
            $table->string('telepon_orangtua')->nullable();
        });
    }
    public function down() {
        Schema::table('murids', function (Blueprint $table) {
            $table->dropColumn(['profile_image', 'phone', 'nama_orangtua', 'telepon_orangtua']);
        });
    }
};
