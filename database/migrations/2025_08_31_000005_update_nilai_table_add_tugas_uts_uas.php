<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('nilai', function (Blueprint $table) {
            $table->integer('nilai_tugas')->nullable();
            $table->integer('nilai_uts')->nullable();
            $table->integer('nilai_uas')->nullable();
            $table->dropColumn('nilai');
        });
    }
    public function down() {
        Schema::table('nilai', function (Blueprint $table) {
            $table->integer('nilai')->nullable();
            $table->dropColumn('nilai_tugas');
            $table->dropColumn('nilai_uts');
            $table->dropColumn('nilai_uas');
        });
    }
};
