<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('contatos', function (Blueprint $table) {
            $table->string("empresa", 255)->after('mensagem')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('contatos', function (Blueprint $table) {
            $table->dropColumn(['empresa']);
        });
    }
};
