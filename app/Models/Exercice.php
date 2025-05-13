<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercice extends Model
{
    use HasFactory;

    protected $fillable = [
        'enseignant_id',
        'classe_id',
        'titre',
        'contenu',
        'date_limite',
    ];

    public function enseignant()
{
    return $this->belongsTo(User::class, 'enseignant_id');
}

public function classe()
{
    return $this->belongsTo(Classe::class);
}

public function answers()
{
    return $this->hasMany(exercice_answers::class);
}
}
