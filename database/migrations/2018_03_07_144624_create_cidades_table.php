<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasTable('cidades')) {
            Schema::create('cidades', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('codcidade');
                $table->string('nome', 255);
                $table->char('uf', 2);
                $table->integer('prioridade');
                $table->string('path')->nullable();
                $table->string('path_com_uf')->nullable();
            });
        }
    }

    public function down() {
        Schema::dropIfExists('cidades');
    }
};
