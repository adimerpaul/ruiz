<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producers', function (Blueprint $table) {
            $table->id();
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->string('ci')->nullable();
            $table->string('edad')->nullable();
            $table->string('nroFamilia')->nullable();
            $table->string('masculino')->nullable();
            $table->string('femenino')->nullable();
            $table->string('varones')->nullable();
            $table->string('mujeres')->nullable();
            $table->string('celular')->nullable();
            $table->string('provincia')->nullable();
            $table->string('departamento')->nullable();
            $table->string('municipio')->nullable();
            $table->string('comunidad')->nullable();
            $table->string('superficie')->nullable();
            $table->string('semilla')->nullable();
            $table->string('abono')->nullable();
            $table->string('maquinaria')->nullable();
            $table->string('riego')->nullable();
            $table->string('quinua')->nullable();
            $table->string('asociacion')->nullable();
            $table->string('si')->nullable();
            $table->string('no')->nullable();
            $table->string('mejorar')->nullable();
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producers');
    }
};
