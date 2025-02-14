<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('encurtados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->nullable(false);
            $table->string('codigo')->nullable(false);
            $table->timestamps();
            $table->enum('status', ['0', '1'])->nullable(false)->default("1");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('encurtados');
    }
};
