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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained('users')->onDelete('cascade'); // L'élève
            $table->foreignId('matiere_id')->constrained('matieres')->onDelete('cascade'); // Matière (tu peux avoir une table "matieres" si ce n'est pas déjà fait)
            $table->foreignId('enseignant_id')->constrained('users')->onDelete('cascade'); // Enseignant (id de l'enseignant qui donne la note)
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade'); // Classe
            $table->float('note'); // La note de l'élève
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
        Schema::dropIfExists('notes');
    }
};
