<?php

namespace App\Imports;

use App\Models\ExerciceAnswer;
use Maatwebsite\Excel\Concerns\ToModel;


class ExerciceAnswersImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ExerciceAnswer([
            'eleve_id'    => $row[0],
            'exercice_id' => $row[1],
            'reponse'     => $row[2],
            'note'        => $row[3],
        ]);
    }
}
