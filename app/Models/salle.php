<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'capacite'
    ];

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }
}
