<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscritosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscritos', function (Blueprint $table) {
            $table->id();

            // Datos básicos
            $table->unsignedBigInteger('evento_id');
            $table->string('nombre_completo');
            $table->string('numero_documento')->unique();
            $table->integer('edad')->nullable();
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro'])->nullable();
            $table->string('correo')->unique();
            $table->string('telefono');
            $table->string('profesion')->nullable();

            // Datos comunes y específicos del comprador
            $table->string('empresa')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('redes_sociales')->nullable();
            $table->json('productos')->nullable();
            $table->string('producto_otro')->nullable();
            $table->json('segmento_edad')->nullable();
            $table->string('segmento_otro')->nullable();

            // Datos generales
            $table->date('fecha_registro');
            $table->string('comprobante_token')->unique();
            $table->enum('tipo_usuario', ['comprador', 'visitante'])->default('comprador');

            $table->timestamps();

            // Relación con eventos
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
        Schema::dropIfExists('inscritos');
    }
}
