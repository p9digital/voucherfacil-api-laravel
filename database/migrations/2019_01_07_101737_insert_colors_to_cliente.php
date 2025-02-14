<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string("bgcolor", 15)->nullable()->after("logo")->default("#89202b");
            $table->string("bgform", 15)->nullable()->after("bgcolor")->default("#3d71bc");
            $table->string("corfonte", 15)->nullable()->after("bgform")->default("#FFFFFF");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn("bgcolor");
            $table->dropColumn("bgform");
            $table->dropColumn("corfonte");
        });
    }
};
