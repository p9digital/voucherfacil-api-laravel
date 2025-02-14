<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_empresa');
            $table->string('nome_completo');
            $table->string('email');
            $table->string('whatsapp');
            $table->string('uf');
            $table->string('cidade');
            $table->string('segmento_empresa');
            $table->string('atendimentos');
            $table->string('ticket_medio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('empresas');
    }
};
