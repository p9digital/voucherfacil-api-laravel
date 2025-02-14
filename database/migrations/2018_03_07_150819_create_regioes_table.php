<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasTable('regioes')) {
            Schema::create('regioes', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nome', 50)->nullable(false);
            });
        }
    }

    public function down() {
        Schema::dropIfExists('regioes');
    }
};
