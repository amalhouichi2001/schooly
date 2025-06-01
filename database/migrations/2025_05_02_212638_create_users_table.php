<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Informations communes
            $table->string('name'); 
            
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('current_team_id')->nullable();
            $table->rememberToken();
            $table->string('profile_photo_path', 2048)->nullable();

            // Infos spécifiques
            $table->enum('role', ['admin', 'eleve', 'enseignant', 'parent']);
            $table->enum('statut', ['active', 'desactive'])->default('active');
            $table->string('prenom')->nullable(); // utile si tu veux séparer nom/prénom
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('adresse')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('telephone')->nullable();
            $table->foreignId('matiere_id')->nullable()->constrained('matieres')->nullOnDelete(); // Spécifique aux enseignants
            $table->foreignId('classe_id')->nullable()->constrained()->nullOnDelete(); // spécifique élève

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
