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

    "accepted"         => ":attribute må aksepteres.",
    
    "active_url"       => ":attribute er ikke en gyldig URL.",
    
    "after"            => ":attribute må være en dato etter :date.",
    
    "alpha"            => ":attribute kan bare inneholde bokstaver.",
    
    "alpha_dash"       => ":attribute kan bare inneholde bokstaver, tall og bindestreker.",
    
    "alpha_num"        => ":attribute kan bare inneholde bokstaver og tall.",

    "alpha_spaces"     => ":attribute kan bare inneholde bokstaver og mellomrom.",
    
    "before"           => ":attribute må være en dato før :date.",
    
    "between"          => array(
    
        "numeric" => ":attribute må være mellom :min - :max.",
    
        "file"    => ":attribute må være mellom :min - :max kilobytes.",
    
        "string"  => ":attribute må være mellom :min - :max tegn.",
    
    ),
    
    "confirmed"        => ":attribute bekreftelsen stemmer ikke.",
    
    "date"             => ":attribute er ikke en gyldig dato.",
    
    "date_format"      => ":attribute samsvarer ikke med formatet :format.",
    
    "different"        => ":attribute og :other må være forskjellig.",
    
    "digits"           => ":attribute må være :digits sifre.",
    
    "digits_between"   => ":attribute må være mellom :min og :max sifre.",
    
    "email"            => ":attribute formatet er ugyldig.",
    
    "exists"           => "valgt :attribute er ugyldig.",
    
    "image"            => ":attribute må være et bilde.",
    
    "in"               => "valgt :attribute er ugyldig.",
    
    "integer"          => ":attribute må være et heltall.",
    
    "ip"               => ":attribute må være en gyldig IP-adresse.",
    
    "max"              => array(
    
        "numeric" => ":attribute ikke kan være større enn :max.",
    
        "file"    => ":attribute ikke kan være større enn :max kilobytes.",
    
        "string"  => ":attribute ikke kan være større enn :max tegn.",
    
    ),
    
    "mimes"            => ":attribute må være en fil av typen type: :values.",
    
    "min"              => array(
    
        "numeric" => ":attribute må være minst :min.",
    
        "file"    => ":attribute må være minst :min kilobytes.",
    
        "string"  => ":attribute må være minst :min tegn.",
    
    ),
    
    "not_in"           => "valgt :attribute er ugyldig.",
    
    "numeric"          => ":attribute må være et tall.",
    
    "regex"            => ":attribute formatet er ugyldig.",
    
    "required"         => ":attribute feltet er nødvendig.",
    
    "required_with"    => ":attribute feltet er nødvendig når :values er tilstede.",
    
    "required_without" => ":attribute feltet er nødvendig når :values ikke er tilstede.",
    
    "same"             => ":attribute og :other må stemme.",
    
    "size"             => array(
    
        "numeric" => ":attribute må være :size.",
    
        "file"    => ":attribute må være :size kilobytes.",
    
        "string"  => ":attribute må være :size tegn.",
    
    ),
    
    "unique"           => ":attribute har allerede blitt tatt.",
    
    "url"              => ":attribute formatet er ugyldig.",

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
    
            'required' => 'Du må oppgi ditt gamle passord.',
    
            'min' => 'Ditt gamle passord må være minst 6 tegn langt.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'Du må skrive inn et nytt passord.',
    
            'min' => 'Ditt nye passord må være minst 6 tegn langt.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'Du må bekrefte det nye passordet.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'Minutter må være et tall',
    
            'required' => 'Du må angi suspensjonslengden i minutter',
    
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
