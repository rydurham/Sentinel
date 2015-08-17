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

    "accepted"         => ": attribute kabul edilmeli.",
    
    "active_url"       => ": attribute geçerli bir URL değil.",
    
    "after"            => ": attribute şu tarihten :date sonra olmalı.",
    
    "alpha"            => ":attribute yalnızca harf içerebilir.",
    
    "alpha_dash"       => ":attribute sadece harf, sayı ve tire içerebilir.",
    
    "alpha_num"        => ":attribute sadece harf ve sayı içerebilir.",

    "alpha_spaces"     => ":attribute sadece harf ve boşluk içerebilir.",
    
    "before"           => ":attribute :date tarihinden önce olmalı.",
    
    "between"          => array(
    
        "numeric" => ":attribute :min ile :max arasında olmalı.",
    
        "file"    => ":attribute :min kilobyte ile :max kilobyte arasında olmalı.",
    
        "string"  => ":attribute :min karakter ile :max karakter arasında olmalı.",
    
    ),
    
    "confirmed"        => ":attribute teyid edilemedi.",
    
    "date"             => ":attribute geçerli bir tarih değil.",
    
    "date_format"      => ":attribute :format formatına uymuyor.",
    
    "different"        => "The :attribute and :other must be different.",
    
    "digits"           => "The :attribute must be :digits digits.",
    
    "digits_between"   => "The :attribute must be between :min and :max digits.",
    
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
    
        "numeric" => ": attribute :size olmalı.",
    
        "file"    => ":attribute boyutu :size kilobytes olmalıdır.",
    
        "string"  => ": attribute en az :size karakter olmalıdır.",
    
    ),
    
    "unique"           => "Girmiş olduğunuz :attribute kullanılıyor.",
    
    "url"              => "Girmiş olduğunuz : attribute formatı geçersiz.",

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
    
            'required' => 'Eski şifrenizi girmeniz gerekiyor.',
    
            'min' => 'Eski şifrenizin en az 6 karakter uzunluğunda olması gerekiyor.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'Yeni şifrenizi girmeniz gerekiyor.',
    
            'min' => 'Yeni şifreniz en az 6 karakter uzunluğunda olmalıdır.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'Yeni şifrenizi onaylamanız gerekiyor.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'Dakika değeri sayı olmalıdır',
    
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
