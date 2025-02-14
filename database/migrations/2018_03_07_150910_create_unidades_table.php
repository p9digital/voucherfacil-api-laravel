<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasTable('unidades')) {
            Schema::create('unidades', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('cliente_id')->nullable(false);
                $table->string('nome', 255)->nullable(false);
                $table->string('path', 255)->nullable(false);
                $table->integer('estado_id')->nullable(false);
                $table->integer('cidade_id')->nullable(false);
                $table->string('bairro', 45)->nullable(false);
                $table->string('endereco', 255)->nullable(false);
                $table->string('numero', 10)->nullable();
                $table->text('complemento')->nullable();
                $table->string('telefone', 15)->nullable();
                $table->string('telefone2', 15)->nullable();
                $table->string('lat', 45)->nullable();
                $table->string('lng', 45)->nullable();
                $table->string('mapsId', 45)->nullable();
                $table->string('facebook', 255)->nullable();
                $table->string('instagram', 255)->nullable();
                $table->timestamps();
                $table->enum('status', ['0', '1'])->nullable()->default('1');
            });
        }
    }

    public function down() {
        Schema::dropIfExists('unidades');
    }
};
