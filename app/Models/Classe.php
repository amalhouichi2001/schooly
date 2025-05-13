<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $table = 'classes'; // Assure la correspondance avec la table
    protected $fillable = ['nom', 'niveau'];

    /**
     * Élèves appartenant à cette classe.
     */
    public function eleves()
    {
        return $this->hasMany(User::class, 'classe_id')->where('role', 'eleve');
    }

    /**
     * Enseignants liés à cette classe (si relation many-to-many envisagée).
     */
    public function enseignants()
    {
        return $this->belongsToMany(User::class, 'classe_enseignant', 'classe_id', 'enseignant_id')
                    ->where('role', 'enseignant');
    }

    /**
     * Emplois du temps associés à cette classe.
     */
    public function emplois()
    {
        return $this->hasMany(Seance::class, 'classe_id');
    }
}
