<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('promocoes', function (Blueprint $table) {
            $table->integer("limite_vouchers")->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('promocoes', function (Blueprint $table) {
            $table->dropColumn("limite_vouchers");
        });
    }
};
