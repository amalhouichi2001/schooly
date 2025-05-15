<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

     protected $fillable = ['eleve_id', 'enseignant_id', 'matiere_id', 'note', 'classe_id'];


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
