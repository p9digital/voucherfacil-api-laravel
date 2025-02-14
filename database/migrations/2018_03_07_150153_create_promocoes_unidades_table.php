<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasTable('promocoes_unidades')) {
            Schema::create('promocoes_unidades', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('promocao_id')->nullable(false);
                $table->integer('unidade_id')->nullable(false);
                $table->timestamps();
                $table->enum('status', ['0', '1'])->default('1')->nullable(false);
            });
        }
    }

    public function down() {
        Schema::dropIfExists('promocoes_unidades');
    }
};
