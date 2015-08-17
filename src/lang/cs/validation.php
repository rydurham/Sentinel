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

    "accepted"         => "Je potřeba potvrdit :attribute.",
    
    "active_url"       => ":attribute není platná adresa URL.",
    
    "after"            => ":attribute nemůže být dříve než :date.",
    
    "alpha"            => ":attribute může obsahovat pouze písmena.",
    
    "alpha_dash"       => ":attribute může obsahovat pouze písmena, čísla, a pomlčky.",
    
    "alpha_num"        => ":attribute může obsahovat pouze písmena čísla.",

    "alpha_spaces"     => ":attribute může obsahovat pouze písmena a mezery.",
    
    "before"           => ":attribute nemůže být později než :date.",
    
    "between"          => array(
    
        "numeric" => ":attribute musí být mezi :min - :max.",
    
        "file"    => ":attribute musí být mezi :min - :max kilobajtů.",
    
        "string"  => ":attribute musí být v rozmezí :min - :max znaků.",
    
    ),
    
    "confirmed"        => "Potvrzení :attribute se neshoduje.",
    
    "date"             => ":attribute není platné datum.",
    
    "date_format"      => ":attribute se neshoduje se správným formátem :format.",
    
    "different"        => ":attribute a: :other se musí lišit.",
    
    "digits"           => ":attribute musí obsahovat :digits číslic.",
    
    "digits_between"   => ":attribute musí být v rozmezí :min a: max číslic.",
    
    "email"            => "Formát :attribute je neplatný.",
    
    "exists"           => ":attribute je neplatný.",
    
    "image"            => ":attribute musí být obrázek.",
    
    "in"               => ":attribute je neplatný.",
    
    "integer"          => ":attribute musí být číslo.",
    
    "ip"               => ":attribute musí být platnou adresu IP.",
    
    "max"              => array(
    
        "numeric" => ":attribute nesmí být vyšší než :max.",
    
        "file"    => ":attribute nesmí být vyšší než :max kilobajtů.",
    
        "string"  => ":attribute nesmí být vyšší než :max znaků.",
    
    ),
    
    "mimes"            => ":attribute musí být soubor typu: :values.",
    
    "min"              => array(
    
        "numeric" => ":attribute musí být alespoň :min.",
    
        "file"    => ":attribute musí být alespoň :min kilobajtů.",
    
        "string"  => ":attribute musí mít alespoň :min znaků.",
    
    ),
    
    "not_in"           => ":attribute je neplatný.",
    
    "numeric"          => ":attribute musí být číslo.",
    
    "regex"            => "Formát :attribute je neplatný.",
    
    "required"         => "Pole :attribute je požadováno.",
    
    "required_with"    => "Pole :attribute je požadováno když :values je k dispozici.",
    
    "required_without" => "Pole :attribute je požadováno když :values není k dispozici.",
    
    "same"             => ":attribute a: :other se musí shodovat.",
    
    "size"             => array(
    
        "numeric" => ":attribute musí být :size.",
    
        "file"    => ":attribute musí mít velikost :size KB.",
    
        "string"  => ":attribute musí mít :size znaků.",
    
    ),
    
    "unique"           => ":attribute již byl zabrán.",
    
    "url"              => "Formát :attribute je neplatný.",

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
    
            'required' => 'Musíte zadat staré heslo.',
    
            'min' => 'Heslo musí být alespoň 6 znaků dlouhé.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'Je třeba zadat nové heslo.',
    
            'min' => 'Heslo musí být alespoň 6 znaků dlouhé.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'Musíte potvrdit vaše nové heslo.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'Minuty musí být číslo',
    
            'required' => 'Je nutné zadat délku pozastavení v minutách',
    
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
