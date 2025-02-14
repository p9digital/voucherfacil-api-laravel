<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasTable('periodos')) {
            Schema::create('periodos', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('promocaounidade_id')->nullable(false);
                $table->string('nome', 255)->nullable(false);
                $table->string('periodo', 255)->nullable();
                $table->integer('ordem')->nullable();
                $table->timestamps();
                $table->enum('status', ['0', '1'])->default('1')->nullable(false);
            });
        }
    }

    public function down() {
        Schema::dropIfExists('periodos');
    }
};
