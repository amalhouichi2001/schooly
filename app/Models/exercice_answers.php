<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class exercice_answers extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercice_id',
        'eleve_id',
        'reponse',
        'submitted_at',
    ];

    public function exercice()
    {
        return $this->belongsTo(Exercice::class);
    }

    public function eleve()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
