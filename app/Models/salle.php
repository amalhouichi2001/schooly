<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

<<<<<<< HEAD:app/Models/salle.php
class Salle extends Model
=======
class salles extends Model
>>>>>>> c1aa0d88dfee6514ac872efcbae2e14884711fc5:app/Models/salles.php
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
