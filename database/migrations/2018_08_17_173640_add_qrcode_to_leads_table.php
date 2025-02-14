<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('leads', function (Blueprint $table) {
            $table->string("qrcode")->after("validado")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropColumn(['qrcode']);
        });
    }
};
