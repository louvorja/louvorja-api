<?php

namespace App\Helpers;

class Validations
{

    public static function validationMessages($key = "")
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'O campo :attribute deve conter um endereço de email válido.',
            'unique' => 'O :attribute já está em uso.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'exists' => 'O :attribute escolhido é inválido.',
        ];
    }
}
