<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = ['eleve_id', 'date', 'motif', 'justifie'];

    public function eleve() {
        return $this->belongsTo(Eleve::class);
    }
    
}
