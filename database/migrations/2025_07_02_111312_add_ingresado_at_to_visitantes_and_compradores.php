<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIngresadoAtToVisitantesAndCompradores extends Migration
{
    public function up()
    {
        Schema::table('visitantes', function (Blueprint $t) {
            $t->timestamp('ingresado_at')->nullable()->after('comprobante_token');
        });
        Schema::table('compradores', function (Blueprint $t) {
            $t->timestamp('ingresado_at')->nullable()->after('comprobante_token');
        });
    }

    public function down()
    {
        Schema::table('visitantes', fn($t) => $t->dropColumn('ingresado_at'));
        Schema::table('compradores', fn($t) => $t->dropColumn('ingresado_at'));
    }
}

