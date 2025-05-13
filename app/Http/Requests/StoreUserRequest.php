<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,eleve,enseignant,parent',
            'telephone'=> 'required|string',
            'gender'=> 'required|string',
            'matiere_id' => 'nullable|exists:matieres,id',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->role !== 'enseignant' && $this->filled('matiere_id')) {
                $validator->errors()->add('matiere_id', 'Seuls les enseignants peuvent avoir une matière.');
            }
        });
    }
}
