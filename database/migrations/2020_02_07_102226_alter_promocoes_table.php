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
            $table->integer("dias_range")->nullable();
            $table->bigInteger('valor_de')->nullable();
            $table->bigInteger('valor_atual')->nullable();
            $table->integer('numero_pessoas')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('promocoes', function (Blueprint $table) {
            $table->dropColumn('valor_de');
            $table->dropColumn('dias_range');
            $table->dropColumn('valor_atual');
            $table->dropColumn('numero_pessoas');
        });
    }
};
