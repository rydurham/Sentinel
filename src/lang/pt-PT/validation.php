<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    "accepted"         => "O :attribute tem de ser aceite.",
    
    "active_url"       => "O :attribute não é um URL válido.",
    
    "after"            => "O :attribute deverá ser uma data posterior a :date.",
    
    "alpha"            => "O :attribute só deve conter letras.",
    
    "alpha_dash"       => "O :attribute só deve conter letras, números e hífens.",
    
    "alpha_num"        => "O :attribute só deve conter letras e números.",

    "alpha_spaces"     => "O :attribute só deve conter letras e espaços.",
    
    "before"           => "O :attribute deverá ser uma data anterior a :date.",
    
    "between"          => array(
    
        "numeric" => "O :attribute deve estar entre: min -: máx.",
    
        "file"    => "O :attribute deve ter entre :min e :max kilobytes.",
    
        "string"  => "O :attribute deve ter entre :min e :max caractéres.",
    
    ),
    
    "confirmed"        => "A confirmação do :attribute não coincide.",
    
    "date"             => "A :attribute não é uma data válida.",
    
    "date_format"      => "O valor de :attribute não coincide com o fomato :format.",
    
    "different"        => "O :attribute e :other devem ser diferentes.",
    
    "digits"           => "O :attribute deve ter :digits dígitos.",
    
    "digits_between"   => "O :attribute deve ter entre :min e :max dígitos.",
    
    "email"            => "O :attribute tem um formato inválido.",
    
    "exists"           => "O :attribute seleccionado é inválido.",
    
    "image"            => "O :attribute deve ser uma imagem.",
    
    "in"               => "O :attribute seleccionado é inválido.",
    
    "integer"          => "O :attribute deve ser um número inteiro.",
    
    "ip"               => "O :attribute deve ser um endereço IP válido.",
    
    "max"              => array(
    
        "numeric" => "O :attribute não deve ser maior que :max.",
    
        "file"    => "O :attribute não deve ser maior que :max kilobytes.",
    
        "string"  => "O :attribute não deve ter mais de :max caractéres.",
    
    ),
    
    "mimes"            => "O :attribute deve ser um ficheiro do tipo: :attribute.",
    
    "min"              => array(
    
        "numeric" => "O :attribute deve ser pelo menos :min.",
    
        "file"    => "O :attribute deve ter no mínimo :min kilobytes.",
    
        "string"  => "O :attribute dever ter no mínimo :min caractéres.",
    
    ),
    
    "not_in"           => "O :attribute seleccionado é inválido.",
    
    "numeric"          => "O :attribute deve ser um número.",
    
    "regex"            => "O :attribute tem um formato inválido.",
    
    "required"         => "O campo :attribute é obrigatório.",
    
    "required_with"    => "O campo :attribute é obrigatório quando o :value se encontra definido.",
    
    "required_without" => "O campo :attribute é obrigatório quando o :value não se encontra definido.",
    
    "same"             => "O :attribute e :other devem corresponder.",
    
    "size"             => array(
    
        "numeric" => "O tamanho de :attribute deve ser :size.",
    
        "file"    => "O :attribute deve ter :size kilobytes.",
    
        "string"  => "O :attribute deve ter :size caractéres.",
    
    ),
    
    "unique"           => "O :attribute já se encontra em uso.",
    
    "url"              => "O :attribute tem um formato inválido.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => array(
    
        'oldPassword' => array(
    
            'required' => 'Deve inserir a sua senha antiga.',
    
            'min' => 'A sua palavra-passe antiga tem de ter pelo menos 6 caracteres.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'Deve inserir uma nova palavra-passe.',
    
            'min' => 'A sua palavra-passe nova tem de ter pelo menos 6 caracteres.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'Deve confirmar sua nova palavra-passe.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'Minutos devem ser um número',
    
            'required' => 'Deve especificar a duração da suspensão em minutos',
    
        ),
    
    ),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => array(),

);
