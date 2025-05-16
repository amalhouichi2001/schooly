<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = [
        'eleve_id',
        'classe_id',
        'statut',
        'date_inscription'
    ];

    public function eleve()
    {
        return $this->belongsTo(User::class, 'eleve_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
