<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = [
        'classe_id',
        'enseignant_id',
        'matiere_id',
        'salle_id',
        'date',
        'heure_debut',
        'heure_fin',
        'duration',
        'type',
    ];

    protected $casts = [
        'date' => 'date',
        'heure_debut' => 'datetime:H:i',
        'heure_fin' => 'datetime:H:i',
    ];

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }


    public function matiere() {
    return $this->belongsTo(Matiere::class, 'matiere_id');
}
public function salle() {
    return $this->belongsTo(Salle::class, 'salle_id');
}

}
