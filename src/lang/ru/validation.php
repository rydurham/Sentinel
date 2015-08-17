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

    "accepted"         => "Условие пункта :attribute должны быть приняты.",
    
    "active_url"       => ":attribute является некорректным URL.",
    
    "after"            => ":attribute должены быть датой после :date.",
    
    "alpha"            => "Поле :attribute должно содержать только буквы.",
    
    "alpha_dash"       => ":attribute может содержать только латинские буквы, цифры и дефис.",
    
    "alpha_num"        => ":attribute может содержать только латинские буквы, цифры.",

    "alpha_spaces"     => ":attribute может содержать только латинские буквы и пробелы.",
    
    "before"           => ":attribute дата должна быть до :date.",
    
    "between"          => array(
    
        "numeric" => ":attribute должен быть между :min - :max.",
    
        "file"    => ": attribute должен быть между  :min - :max килобайт.",
    
        "string"  => ":attribute должен быть между :min - :max символов.",
    
    ),
    
    "confirmed"        => "Подтверждение :attribute не совпадает.",
    
    "date"             => ":attribute не является допустимой датой.",
    
    "date_format"      => ":attribute не соответствует формату :format.",
    
    "different"        => ":attribute и  :other должны быть разными.",
    
    "digits"           => ":attribute должен быть :digits цифры.",
    
    "digits_between"   => ":attribute должен быть между  :min и :max цифр.",
    
    "email"            => "The :attribute format is invalid.",
    
    "exists"           => "The selected :attribute is invalid.",
    
    "image"            => "The :attribute must be an image.",
    
    "in"               => "The selected :attribute is invalid.",
    
    "integer"          => "The :attribute must be an integer.",
    
    "ip"               => "The :attribute must be a valid IP address.",
    
    "max"              => array(
    
        "numeric" => "The :attribute may not be greater than :max.",
    
        "file"    => "The :attribute may not be greater than :max kilobytes.",
    
        "string"  => "The :attribute may not be greater than :max characters.",
    
    ),
    
    "mimes"            => "The :attribute must be a file of type: :values.",
    
    "min"              => array(
    
        "numeric" => "The :attribute must be at least :min.",
    
        "file"    => "The :attribute must be at least :min kilobytes.",
    
        "string"  => "The :attribute must be at least :min characters.",
    
    ),
    
    "not_in"           => "The selected :attribute is invalid.",
    
    "numeric"          => "The :attribute must be a number.",
    
    "regex"            => "The :attribute format is invalid.",
    
    "required"         => "The :attribute field is required.",
    
    "required_with"    => "The :attribute field is required when :values is present.",
    
    "required_without" => "The :attribute field is required when :values is not present.",
    
    "same"             => "The :attribute and :other must match.",
    
    "size"             => array(
    
        "numeric" => "The :attribute must be :size.",
    
        "file"    => "The :attribute must be :size kilobytes.",
    
        "string"  => "The :attribute must be :size characters.",
    
    ),
    
    "unique"           => "The :attribute has already been taken.",
    
    "url"              => "The :attribute format is invalid.",

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
    
            'required' => 'Вы должны ввести свой старый пароль.',
    
            'min' => 'Ваш старый пароль должен быть длиной не менее 6 символов.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'Вам необходимо ввести новый пароль.',
    
            'min' => 'Ваш новый пароль должен иметь длину не менее 6 символов.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'Вы должны подтвердить ваш новый пароль.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'Minutes must be a number',
    
            'required' => 'You must specify suspension length in minutes',
    
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
