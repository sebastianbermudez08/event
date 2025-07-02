<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompradorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compradores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evento_id');
            $table->string('nombre_completo');
            $table->string('numero_documento')->unique();
            $table->string('correo')->unique();
            $table->string('telefono');
            $table->string('empresa');
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('redes_sociales')->nullable();
            $table->json('productos')->nullable();
            $table->string('producto_otro')->nullable();
            $table->json('segmento_edad')->nullable();
            $table->string('segmento_otro')->nullable();
            $table->string('comprobante_token')->unique();
            $table->date('fecha_registro');
            $table->timestamps();

            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compradors');
    }
}
