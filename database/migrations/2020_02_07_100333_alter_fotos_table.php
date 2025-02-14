<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('fotos', function (Blueprint $table) {
            $table->string('foto_mob')->nullable();
            $table->string('foto_card')->nullable();
            $table->string('foto_mob_xs')->nullable();
            $table->string('foto_desk')->nullable();
            $table->string('foto_desk_xl')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('fotos', function (Blueprint $table) {
            $table->dropColumn('foto_mob');
            $table->dropColumn('foto_card');
            $table->dropColumn('foto_mob_xs');
            $table->dropColumn('foto_desk');
            $table->dropColumn('foto_desk_xl');
        });
    }
};
