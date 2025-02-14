<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasTable('estados')) {
            Schema::create('estados', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('coduf');
                $table->string('nome', 50);
                $table->char('uf', 2);
                $table->integer('regiao');
            });
        }
    }

    public function down() {
        Schema::dropIfExists('estados');
    }
};
