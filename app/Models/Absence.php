<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    protected $fillable = ['eleve_id', 'seance_id', 'enseignant_id', 'motif', 'date'];

    public function eleve() {
    return $this->belongsTo(User::class, 'eleve_id')->where('role', 'eleve');
}


public function enseignant() {
    return $this->belongsTo(User::class, 'enseignant_id')->where('role', 'enseignant');
}
public function seance()
{
    return $this->belongsTo(Seance::class);
}
    
}
