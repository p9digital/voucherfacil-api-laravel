<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        if (!Schema::hasTable('promocoes')) {
            Schema::create('promocoes', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('cliente_id')->nullable();
                $table->string('titulo', 255)->nullable(false);
                $table->string('path', 255)->nullable(false);
                $table->text('resumo')->nullable();
                $table->longtext('descricao')->nullable();
                $table->text('regras')->nullable();
                $table->text('observacoes')->nullable();
                $table->string('desconto', 255)->nullable();
                $table->decimal('valor', 15, 2)->nullable();
                $table->string('codigo', 255)->nullable(false);
                $table->timestamp('dataInicio')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('dataFim')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('dataPublicacao')->nullable(false)->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->string('pessoas', 100)->nullable(false);
                $table->string('periodo', 100)->nullable(false);
                $table->string('agendamento', 100)->nullable(false);
                $table->integer('limite')->nullable(false)->default('0');
                $table->string('imagem', 255)->nullable();
                $table->text('metaDescription')->nullable();
                $table->string('metaKeywords', 255)->nullable();
                $table->text('codigosAcompanhamento')->nullable();
                $table->text('codigosConversao')->nullable();
                $table->text('codigosAnalytics')->nullable();
                $table->enum('mostrar', ['0', '1'])->default('1')->nullable(false);
                $table->timestamps();
                $table->enum('status', ['0', '1'])->default('1')->nullable(false);
            });
        }
    }

    public function down() {
        Schema::dropIfExists('promocoes');
    }
};
