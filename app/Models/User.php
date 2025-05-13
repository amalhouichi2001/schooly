<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Collection;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'statut',
        'prenom',
        'gender',
        'adresse',
        'date_naissance',
        'telephone',
        'specialite',
        'classe_id',
        'profile_photo_path',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // ========== Helpers pour vérifier le rôle ==========

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEnseignant()
    {
        return $this->role === 'enseignant';
    }

    public function isEleve()
    {
        return $this->role === 'eleve';
    }

    public function isParent()
    {
        return $this->role === 'parent';
    }

    public function isActive()
    {
        return $this->statut === 'active';
    }

    // ========= Relations en fonction des rôles ==========

    // Relation pour les enseignants : leurs exercices créés
    public function exercicesCrees()
    {
        return $this->hasMany(Exercice::class, 'enseignant_id');
    }

    // Relation pour les élèves : leurs réponses aux exercices
    public function exerciceAnswers()
    {
        return $this->hasMany(exercice_answers::class, 'user_id');
    }

    // Relation avec la classe (uniquement pour les élèves)
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id');
    }

    // Emploi du temps lié à la classe de l'élève
    public function emploiEleve()
    {
        return $this->classe ? $this->classe->seances() : null;
    }

    // Si l'utilisateur est un enseignant, on récupère ses emplois du temps
    public function emploiEnseignant()
    {
        return $this->hasMany(Seance::class, 'enseignant_id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'eleve_id');
    }
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
    // Parents de l'élève
    public function parents()
    {
        return $this->belongsToMany(User::class, 'parent_eleve', 'eleve_id', 'parent_id')
            ->where('role', 'parent');
    }

    // Enfants d'un parent
    public function enfants()
    {
        return $this->belongsToMany(User::class, 'parent_eleve', 'parent_id', 'eleve_id')
            ->where('role', 'eleve');
    }
    public function absencesEnseignant()
    {
        return $this->hasMany(Absence::class, 'enseignant_id');
    }

    public function absencesEleve()
    {
        return $this->hasMany(Absence::class, 'eleve_id');
    }
}
