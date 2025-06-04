<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Event extends Model
{
    protected $fillable = ['titre', 'description', 'date', 'acces_parents', 'acces_enseignants', 'acces_eleves'];

   
public function participants()
{
    return $this->belongsToMany(User::class, 'event_user'); 
}

}
