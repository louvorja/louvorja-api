<?php

namespace App\Helpers;

class Validations
{

    public static function validationMessages($key = "")
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'username.required' => 'O campo nome de usuário é obrigatório.',
            'username.unique' => 'O nome de usuário já está em uso.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve conter um endereço de email válido.',
            'email.unique' => 'O email já está em uso.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'slug.required' => 'O campo nome de url é obrigatório.',
            'id_language.required' => 'O campo idioma é obrigatório.',
            'id_language.exists' => 'O idioma escolhido é inválido.',
        ];
    }
}
