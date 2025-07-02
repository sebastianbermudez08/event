<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evento_id');
            $table->string('nombre_completo');
            $table->string('numero_documento')->unique();
            $table->integer('edad');
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro']);
            $table->string('correo')->unique();
            $table->string('telefono');
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
        Schema::dropIfExists('visitantes');
    }
}
