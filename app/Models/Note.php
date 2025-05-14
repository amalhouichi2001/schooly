<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'eleve_id',
        'matiere_id',
        'enseignant_id',
        'classe_id',
        'note',
    ];

    // Relations
    public function eleve()
    {
        return $this->belongsTo(User::class, 'eleve_id');
    }

   public function matiere()
{
    return $this->belongsTo(Matiere::class);
}


    public function enseignant()
    {
        return $this->belongsTo(User::class, 'enseignant_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
