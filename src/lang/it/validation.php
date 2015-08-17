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

    "accepted"         => "Il campo :attribute deve essere accettato.",
    
    "active_url"       => "Il campo :attribute non contiene un URL non attivo.",
    
    "after"            => "Il campo :attribute deve contenere una data successiva a :date.",
    
    "alpha"            => "Il campo :attribute può contenere solo lettere.",
    
    "alpha_dash"       => "Il campo :attribute può contenere solo lettere, numeri e trattini.",
    
    "alpha_num"        => "Il campo :attribute può contenere solo lettere e numeri.",

    "alpha_spaces"     => "Il :attribute può contenere solo lettere e spazi.",
    
    "before"           => "Il campo :attribute deve contenere una data antecedente :date.",
    
    "between"          => array(
    
        "numeric" => "Il campo :attribute deve contenere un numero tra :min e :max.",
    
        "file"    => "Il campo :attribute deve contenere un file che occupi da :min a :max kilobyte.",
    
        "string"  => "Il campo :attribute deve contenere da :min a :max caratteri.",
    
    ),
    
    "confirmed"        => "Il campo :attribute non combacia con il precedente.",
    
    "date"             => "Il campo :attribute non contiene una data valida.",
    
    "date_format"      => "Il campo :attribute non contiene una data con il formato :format.",
    
    "different"        => "I campi :attribute e :other devono contenere valori diversi.",
    
    "digits"           => "Il campo :attribute deve contenere :digits cifre.",
    
    "digits_between"   => "Il campo :attribute deve contenere dalle :min alle :max cifre.",
    
    "email"            => "Il campo :attribute deve contenere un indirizzo eMail valido.",
    
    "exists"           => "Il valore del campo :attribute esiste già.",
    
    "image"            => "Il campo :attribute deve contenere un'immagine.",
    
    "in"               => "Il campo :attribute contiene un valore non valido.",
    
    "integer"          => "Il campo :attribute deve contenere un numero intero.",
    
    "ip"               => "Il campo :attribute deve contenere un indirizzo IP valido.",
    
    "max"              => array(
    
        "numeric" => "Il campo :attribute non può contenere un numero maggiore di :max.",
    
        "file"    => "Il campo :attribute deve contenere un file che occupi massimo :max kilobytes.",
    
        "string"  => "Il campo :attribute non può contenere più di :max caratteri.",
    
    ),
    
    "mimes"            => "Il campo :attribute deve contenere un file del tipo: :values.",
    
    "min"              => array(
    
        "numeric" => "Il campo :attribute non può contenere un numero minore di :min.",
    
        "file"    => "Il campo :attribute deve contenere un file che occupi minimo :min kilobyte.",
    
        "string"  => "Il campo :attribute deve contenere almeno :min caratteri.",
    
    ),
    
    "not_in"           => "Il campo :attribute contiene un valore non valido.",
    
    "numeric"          => "Il campo :attribute deve essere un numero.",
    
    "regex"            => "Il campo :attribute contiene un valore con un formato non valido.",
    
    "required"         => "Il campo :attribute è obbligatorio.",
    
    "required_with"    => "Il campo :attribute è obbligatorio quando :values è presente.",
    
    "required_without" => "Il campo :attribute è obbligatorio quando :values non è presente.",
    
    "same"             => "I campi :attribute e :other devono contenere lo stesso valore.",
    
    "size"             => array(
    
        "numeric" => "Il campo :attribute deve contenere un numero pari a :size.",
    
        "file"    => "Il campo :attribute deve contenere un file che occupi :size kilobyte.",
    
        "string"  => "Il campo :attribute deve contenere :size caratteri.",
    
    ),
    
    "unique"           => "Il valore del campo :attribute è già stato preso.",
    
    "url"              => "Il campo :attribute contiene un URL non valido.",

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
    
            'required' => 'È necessario inserire la vecchia password.',
    
            'min' => 'La vecchia password deve essere di almeno 6 caratteri.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'È necessario inserire una nuova password.',
    
            'min' => 'La nuova password deve essere di almeno 6 caratteri.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'È necessario confermare la nuova password.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'Verbale deve essere un numero.',
    
            'required' => 'È necessario specificare la lunghezza della sospensione in pochi minuti.',
    
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
