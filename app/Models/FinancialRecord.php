<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class FinancialRecord extends Model
{
    protected $fillable = ['user_id', 'type', 'description', 'montant', 'date'];

    public function enseignant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
