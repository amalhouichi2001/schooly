<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;
class Seance extends Model
{

    

    protected $fillable = [
        'date',
        'heure_debut',
        'heure_fin',
        'matiere_id',
        'enseignant_id',
        'salle_id',
        'classe_id',
        'type',
        'duration',
    ];

    // Relations

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
