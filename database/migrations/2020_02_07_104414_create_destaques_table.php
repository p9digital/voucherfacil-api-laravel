<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('destaques', function (Blueprint $table) {
            $table->increments('id');

            //caso o banner seja vinculado a uma cidade especifica
            $table->integer('cidade_id')->nullable();
            $table->integer('cliente_id')->nullable();
            $table->integer('promocao_id')->nullable();
            $table->integer('visivel_somente_cidade')->nullable()->default(0);

            $table->string('titulo')->nullable();
            $table->string('subtitulo')->nullable();
            $table->string('descricao')->nullable();
            $table->string('link')->nullable();

            $table->string('foto_original')->nullable();
            $table->string('foto_desk_xxl')->nullable();
            $table->string('foto_desk_xl')->nullable();
            $table->string('foto_desk')->nullable();
            $table->string('foto_mob')->nullable();
            $table->string('foto_mob_xs')->nullable();
            $table->string('foto_mob_xxs')->nullable();

            $table->integer('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('destaques');
    }
};
