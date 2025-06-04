<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Création des classes
        $classe1 = DB::table('classes')->insertGetId([
            'nom' => 'Classe A',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Création des matières
        $matiere1 = DB::table('matieres')->insertGetId([
            'nom' => 'Mathématiques',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Création des salles
        $salle1 = DB::table('salles')->insertGetId([
            'nom' => 'Salle 101',
            'capacite' => 30,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Utilisateur admin
        $admin = DB::table('users')->insertGetId([
            'name' => 'Admin Principal',
            'prenom'=>'prince',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'gender' => 'female',
            'role' => 'admin',
            'statut' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Enseignant
        $enseignant = DB::table('users')->insertGetId([
            'name' => 'M. Dupont',
            'prenom'=>'prince',
            'email' => 'enseignant@example.com',
            'password' => Hash::make('password'),
            'role' => 'enseignant',
            'gender' => 'male',
            'matiere_id' => $matiere1,
            'statut' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Élève
        $eleve = DB::table('users')->insertGetId([
            'name' => 'Élève Martin',
            'prenom'=>'prince',
            'email' => 'eleve@example.com',
            'password' => Hash::make('password'),
            'role' => 'eleve',
            'gender' => 'female',
            'classe_id' => $classe1,
            'statut' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Parent
        $parent = DB::table('users')->insertGetId([
            'name' => 'Mme Martin',
            'prenom'=>'prince',
            'email' => 'parent@example.com',
            'password' => Hash::make('password'),
            'role' => 'parent',
            'gender' => 'female',
            'statut' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Lien parent/élève
        DB::table('parent_eleve')->insert([
            'parent_id' => $parent,
            'eleve_id' => $eleve,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Inscription
        DB::table('inscriptions')->insert([
            'eleve_id' => $eleve,
            'classe_id' => $classe1,
            'date_inscription' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Séance
        $seance = DB::table('seances')->insertGetId([
    'classe_id' => $classe1,
    'enseignant_id' => $enseignant,
    'date' => Carbon::today(),
    'heure_debut' => '08:00:00',
    'heure_fin' => '09:00:00',
    'duration' => 60,
    'matiere_id' => $matiere1,
    'salle_id' => $salle1,
    'type' => 'cours',
    'created_at' => now(),
    'updated_at' => now(),
]);

        // Absence
        DB::table('absences')->insert([
            'eleve_id' => $eleve,
            'seance_id' => $seance,
            'enseignant_id' => $enseignant,
            'motif' => 'Maladie',
            'date' => Carbon::today(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Note
        DB::table('notes')->insert([
            'eleve_id' => $eleve,
            'matiere_id' => $matiere1,
            'enseignant_id' => $enseignant,
            'classe_id' => $classe1,
            'note' => 14.5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Message
        DB::table('messages')->insert([
            'sender_id' => $enseignant,
            'receiver_id' => $parent,
            'content' => 'Votre enfant était absent aujourd\'hui.',
            'status' => 'sent',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
