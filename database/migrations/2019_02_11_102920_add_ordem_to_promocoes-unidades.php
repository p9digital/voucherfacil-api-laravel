<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('promocoes_unidades', function (Blueprint $table) {
            $table->integer("ordem")->nullable(true)->after("unidade_id")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('promocoes_unidades', function (Blueprint $table) {
            $table->dropColumn("ordem");
        });
    }
};
