<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasTable('clientes')) {
            Schema::create('clientes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('razaoSocial', 255)->nullable(false);
                $table->string('nomeFantasia', 255);
                $table->string('path', 255)->nullable(false);
                $table->string('logo', 255);
                $table->timestamps();
                $table->enum('status', ['0', '1'])->default('1')->nullable(false);
            });
        }
    }

    public function down() {
        Schema::dropIfExists('clientes');
    }
};
