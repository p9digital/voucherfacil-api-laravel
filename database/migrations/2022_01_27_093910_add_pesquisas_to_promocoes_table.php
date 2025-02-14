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
            $table->enum("pesquisa", ["0", "1"])->default("0");
            $table->longText("pesquisas")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('promocoes', function (Blueprint $table) {
            $table->dropColumn("pesquisa");
            $table->dropColumn("pesquisas");
        });
    }
};
