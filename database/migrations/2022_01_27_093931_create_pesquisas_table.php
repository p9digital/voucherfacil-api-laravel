<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('pesquisas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('promocao_id');
            $table->integer('unidade_id');
            $table->integer('lead_id')->nullable();
            $table->longText('pesquisas');
            $table->longText('respostas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('pesquisas');
    }
};
