<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = ['inscription_id', 'montant', 'mode', 'date', 'statut'];

    public function inscription()
    {
        return $this->belongsTo(Inscription::class);
    }
}