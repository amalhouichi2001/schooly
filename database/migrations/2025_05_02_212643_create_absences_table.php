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
        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seance_id')->constrained()->onDelete('cascade');
            $table->foreignId('enseignant_id')->constrained('users')->onDelete('cascade'); // User avec rôle "enseignant"
            $table->text('motif')->nullable(); 
            $table->boolean('justifie')->default(false);// facultatif
            $table->date('date'); // doublon de sécurité en plus de seance.date
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
        Schema::dropIfExists('absences');
    }
};
