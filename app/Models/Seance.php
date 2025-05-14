<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = [
        'emploi_class_id',
        'emploi_enseignant_id',
        'date',
        'heure_debut',
        'heure_fin',
        'duration',
        'matiere_id',
        'salle_id',
        'type',
    ];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'emploi_class_id');
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'emploi_enseignant_id');
    }
}
