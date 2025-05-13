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
        Schema::create('seances', function (Blueprint $table) {
            $table->id();

            // Liens vers emploi de classe ou d’enseignant
            $table->foreignId('emploi_class_id')->nullable()->constrained('classes')->onDelete('cascade');
            $table->foreignId('emploi_enseignant_id')->nullable()->constrained('users')->onDelete('cascade');

            // Date et horaires
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->integer('duration'); // en minutes

            // Matière et salle (relations)
            $table->foreignId('matiere_id')->constrained('matieres')->onDelete('cascade');
            $table->foreignId('salle_id')->constrained('salles')->onDelete('cascade');

            // Type de séance
            $table->enum('type', ['cours', 'examen'])->default('cours');

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
        Schema::dropIfExists('seances');
    }
};
