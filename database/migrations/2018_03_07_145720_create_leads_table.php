<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasTable('leads')) {
            Schema::create('leads', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('unidade_id')->nullable(false);
                $table->integer('promocao_id')->nullable(false);
                $table->string('nome', 100)->nullable(false);
                $table->string('email', 100)->nullable(false);
                $table->string('telefone', 15)->nullable(false);
                $table->integer('cidade_id')->nullable();
                $table->char('uf', 2)->nullable();
                $table->char('form', 1)->nullable(false);
                $table->string('voucher', 45)->nullable();
                $table->date('data_voucher', 45)->nullable();
                $table->string('horario_voucher', 255)->nullable();
                $table->integer('periodo_id')->nullable();
                $table->integer('pessoas')->nullable()->default('1');
                $table->string('ferramenta_validacao', 255)->nullable();
                $table->string('utm_source', 255)->nullable();
                $table->string('utm_medium', 255)->nullable();
                $table->string('utm_term', 255)->nullable();
                $table->string('utm_campaign', 255)->nullable();
                $table->string('utm_content', 255)->nullable();
                $table->string('gclid', 255)->nullable();
                $table->string('origem', 255)->nullable();
                $table->string('device', 15)->nullable();
                $table->string('ip', 20)->nullable();
                $table->string('hash', 100)->nullable(false);
                $table->enum('validado', ['0', '1'])->default('0')->nullable(false);
                $table->timestamps();
                $table->enum('status', ['0', '1'])->default('1')->nullable(false);
            });
        }
    }

    public function down() {
        Schema::dropIfExists('leads');
    }
};
