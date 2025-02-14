<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasTable('fotos')) {
            Schema::create('fotos', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('promocao_id')->nullable(false);
                $table->string('arquivo', 255)->nullable(false);
                $table->integer('ordem')->default(0)->nullable(false);
                $table->timestamps();
                $table->enum('status', ['0', '1'])->default('1')->nullable(false);
            });
        }
    }

    public function down() {
        Schema::dropIfExists('fotos');
    }
};
