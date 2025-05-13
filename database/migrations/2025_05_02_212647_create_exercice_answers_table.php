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
        Schema::create('exercice_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('exercice_id')->constrained('exercices')->onDelete('cascade');
            $table->foreignId('eleve_id')->constrained('users')->onDelete('cascade');

            $table->text('reponse'); // réponse de l’élève
            $table->timestamp('submitted_at')->nullable(); // date de soumission

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
        Schema::dropIfExists('exercice_answers');
    }
};
