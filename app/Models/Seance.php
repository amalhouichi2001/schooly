<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = ['emploi_class_id', 'emploi_enseignant_id', 'jour', 'seance', 'matiere', 'heure_debut', 'heure_fin', 'type'];

    // Relation vers la classe (si un emploi de classe)
    public function emploiClass()
    {
        return $this->belongsTo(Classe::class, 'emploi_class_id');
    }

    // Relation vers l'enseignant (si un emploi d'enseignant)
    public function emploiEnseignant()
    {
        return $this->belongsTo(User::class, 'emploi_enseignant_id');
    }

    // Accesseur pour récupérer un libellé humain
    public function getTypeLabelAttribute()
    {
        return $this->type === 'cours' ? 'Cours' : 'Examen';
    }
    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
