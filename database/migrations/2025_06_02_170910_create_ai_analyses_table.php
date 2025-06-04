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
    Schema::create('ai_analyses', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('eleve_id')->nullable();
        $table->string('type'); // exemple : recommandation, alerte
        $table->text('contenu'); // description de l’analyse
        $table->timestamps();

        $table->foreign('eleve_id')->references('id')->on('users')->onDelete('set null');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ai_analyses');
    }
};
