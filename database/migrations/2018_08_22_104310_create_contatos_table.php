<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('contatos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome', 255)->nullable(false);
            $table->string('email', 255)->nullable(false);
            $table->string('telefone', 15)->nullable(false);
            $table->string('assunto', 255)->nullable(false);
            $table->text('mensagem')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('contatos');
    }
};
