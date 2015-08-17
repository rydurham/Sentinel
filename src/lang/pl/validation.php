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

    "accepted"         => ":attribute musi zostać zaakceptowane.",
    
    "active_url"       => ":attribute nie jest prawidłowym adresem URL.",
    
    "after"            => ":attribute musi być datą późniejszą niż :date.",
    
    "alpha"            => ":attribute może zawierać tylko litery.",
    
    "alpha_dash"       => ":attribute może zawierać tylko litery, cyfry i podkreślenia.",
    
    "alpha_num"        => ":attribute może zawierać tylko litery i cyfry.",

    "alpha_spaces"     => ":attribute może zawierać tylko litery oraz spacje.",
    
    "before"           => ":attribute musi być datą wcześniejszą niż :date.",
    
    "between"          => array(
    
        "numeric" => ":attribute musi być wartością pomiędzy :min i :max.",
    
        "file"    => ":attribute musi mieć pomiędzy :min a :max kilobajtów.",
    
        "string"  => ":attribute musi mieć pomiędzy :min a :max znaków.",
    
    ),
    
    "confirmed"        => ":attribute nie zgadza się z jego powtórzeniem.",
    
    "date"             => ":attribute nie jest prawidłową datą.",
    
    "date_format"      => ":attribute nie zgadza się z formatem :format.",
    
    "different"        => ":attribute i :other muszą być różne.",
    
    "digits"           => ":attribute musi mieć :digits cyfr.",
    
    "digits_between"   => ":attribute musi mieć pomiędzy :min a :max cyfr.",
    
    "email"            => ":attribute musi być prawidłowym adresem e-mail.",
    
    "exists"           => "wybrany :attribute jest nieprawidłowy.",
    
    "image"            => ":attribute musi być obrazkiem.",
    
    "in"               => "wybrany :attribute jest nieprawidłowy.",
    
    "integer"          => ":attribute musi być liczbą.",
    
    "ip"               => ":attribute musi być poprawnym adresem IP.",
    
    "max"              => array(
    
        "numeric" => ":attribute nie może być większy niż :max.",
    
        "file"    => ":attribute nie może być większy niż :max kilobajtów.",
    
        "string"  => ":attribute nie może być dłuższy niż :max znaków.",
    
    ),
    
    "mimes"            => ":attribute musi być plikiem typu: :values.",
    
    "min"              => array(
    
        "numeric" => ":attribute musi większy lub równy :min.",
    
        "file"    => ":attribute musi mieć co najmniej :min kilobajtów.",
    
        "string"  => ":attribute musi mieć co najmniej :min znaków.",
    
    ),
    
    "not_in"           => "wybrany :attribute jest nieprawidłowy.",
    
    "numeric"          => ":attribute must be a number.",
    
    "regex"            => "format :attribute jest nieprawidłowy.",
    
    "required"         => "pole :attribute jest wymagane.",
    
    "required_with"    => "pole :attribute jest wymagane, gdy :values są zdefiniowane.",
    
    "required_without" => "pole :attribute jest wymagane, gdy :values nie są zdefiniowane.",
    
    "same"             => ":attribute i :other muszą być takie same.",
    
    "size"             => array(
    
        "numeric" => ":attribute must be :size.",
    
        "file"    => ":attribute musi mieć :size kilobajtów.",
    
        "string"  => ":attribute musi mieć :size znaków.",
    
    ),
    
    "unique"           => ":attribute jest już zajęty.",
    
    "url"              => "format :attribute jest nieprawidłowy.",

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
    
            'required' => 'Podaj swoje poprzednie hasło.',
    
            'min' => 'Stare hasło musi mieć co najmniej 6 znaków.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'Wprowadź nowe hasło.',
    
            'min' => 'Nowe hasło musi mieć co najmniej 6 znaków.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'Potwierdź nowe hasło.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'Minuty muszą być liczbą',
    
            'required' => 'Określ długość zawieszenia (w minutach)',
    
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
