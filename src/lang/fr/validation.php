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

    "accepted"         => "Le :attribut doit être accepté.",
    
    "active_url"       => "Le :attribut n'est pas une URL valide.",
    
    "after"            => "Le :attribut doit être une date après :date.",
    
    "alpha"            => "Le :attribut doit contenir uniquement des lettres.",
    
    "alpha_dash"       => "Le :attribut doit contenir uniquement de lettres, de chiffres et de tirets.",
    
    "alpha_num"        => "Le :attribut doit contenir uniquement des lettres et des chiffres.",

    "alpha_spaces"     => "Le :attribut doit contenir uniquement des lettres et des espaces.",
    
    "before"           => "Le :attribut doit être une date avant :date.",
    
    "between"          => array(
    
        "numeric" => "Le :attribut doit être comprise entre :min -:max.",
    
        "file"    => "Le :attribut doit être compris entre :min -:max kilo-octets.",
    
        "string"  => "Le :attribut doit être compris entre: min -:max caractères.",
    
    ),
    
    "confirmed"        => "Le :attribute confirmation ne correspond pas.",
    
    "date"             => "Le :attribut n'est pas une date valide.",
    
    "date_format"      => "Le :attribut ne correspond pas au format :format.",
    
    "different"        => "L'attribut \":attribute\" et l'attribut \":other\" doivent être différents.",
    
    "digits"           => "L'attribut \":attribute\" doit contenir :digits chiffres.",
    
    "digits_between"   => "L'attribut \":attribute\" doit contenir entre :min et :max chiffres.",
    
    "email"            => "Le format de l'attribut \":attribute\" est invalide.",
    
    "exists"           => "L'attribut \":attribute\" selectionné est invalide.",
    
    "image"            => "L'attribut \":attribute\" doit être une image.",
    
    "in"               => "L'attribut \":attribute\" est invalide.",
    
    "integer"          => "L'attribut \":attribute\" doit être un nombre entier.",
    
    "ip"               => "L'attribut \":attribute\" doit être une adresse IP valide.",
    
    "max"              => array(
    
        "numeric" => "L'attribut \":attribute\" ne peut pas être plus grand que :max.",
    
        "file"    => "L'attribut \":attribute\" ne doit pas dépasser :max kilo-octets.",
    
        "string"  => "L'attribut \":attribute\" ne doit pas faire plus de :max caractères.",
    
    ),
    
    "mimes"            => "Le :attribut doit être un fichier de type: :values.",
    
    "min"              => array(
    
        "numeric" => "L'attribut \":attribute\" doit être au moins :min.",
    
        "file"    => "L'attribut \":attribute\" doit faire au moins :min kilo-octets.",
    
        "string"  => "L'attribut \":attribute\" doit faire au moins :min caractères.",
    
    ),
    
    "not_in"           => "L'attribut \":attribute\" est invalide.",
    
    "numeric"          => "L'attribut \":attribute\" doit être un nombre.",
    
    "regex"            => "Le format de l'attribut \":attribute\" est invalide.",
    
    "required"         => "Le champs :attribute est nécessaire.",
    
    "required_with"    => "Le champ :attribute est nécessaire quand :values est présent.",
    
    "required_without" => "Le champ :attribute est nécessaire quand :values n'est pas présent.",
    
    "same"             => "L'attribut \":attribute\" et :other doivent correspondre.",
    
    "size"             => array(
    
        "numeric" => "L'attribut \":attribute\" doit faire :size.",
    
        "file"    => "L'attribut \":attribute\" doit faire :size kilo-octets.",
    
        "string"  => "L'attribut \":attribute\" doit faire :size caractères.",
    
    ),
    
    "unique"           => "Cet-te :attribute a déjà été pris-e.",
    
    "url"              => "Le format de l'attribut \":attribute\" est invalide.",

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
    
            'required' => 'Vous devez entrer votre ancien mot de passe.',
    
            'min' => 'Votre ancien mot de passe doit comporter au moins 6 caractères.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'Vous devez entrer un nouveau mot de passe.',
    
            'min' => 'Votre nouveau mot de passe doit comporter au moins 6 caractères.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'Vous devez confirmer votre nouveau mot de passe.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'Minutes doivent être un nombre',
    
            'required' => 'Vous devez spécifier la longueur de la suspension en minutes',
    
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
