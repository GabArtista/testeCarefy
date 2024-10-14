<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id(); // campo id
            $table->unsignedBigInteger('patient_id'); // campo para o id do paciente
            $table->string('description'); // campo description
            $table->date('entry')->nullable(); // campo entry
            $table->date('exit')->nullable(); // campo exit
            $table->timestamps(); // campos created_at e updated_at

            // Definindo a chave estrangeira
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guides', function (Blueprint $table) {
            // Remover a chave estrangeira antes de dropar a tabela
            $table->dropForeign(['patient_id']);
        });

        Schema::dropIfExists('guides');
    }
}
