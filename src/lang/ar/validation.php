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

    "accepted"         => ":attribute يجب أن يكون مقبولا.",
    
    "active_url"       => ":attribute رابط غير صحيح.",
    
    "after"            => ":attribute يجب أن يكون بعد هذا التاريخ :date.",
    
    "alpha"            => ":attribute قد تحوي حروفا فقط.",
    
    "alpha_dash"       => ":attribute قد تحوي فقط حروف, أرقام و رموز.",
    
    "alpha_num"        => ":attribute قد تحوي فقط حروف و أرقام.",

    "alpha_spaces"     => ":attribute قد تحوي فقط حروف و فراغات.",
    
    "before"           => ":attribute يجب أن يكون قبل هذا التاريخ :date.",
    
    "between"          => array(
    
        "numeric" => ":attribute يجب أن يكون بين :min - :max.",
    
        "file"    => ":attribute يجب أن يكون بين :min - :max kilobytes.",
    
        "string"  => ":attribute يجب أن يكون بين :min - :max حرفا.",
    
    ),
    
    "confirmed"        => ":attribute التأكيد غير متطابقة.",
    
    "date"             => ":attribute تاريخ غيرصحيح.",
    
    "date_format"      => ":attribute غير متطابق مع التنسيق :format.",
    
    "different"        => ":attribute و :other يجب أن يكونا مختلفين.",
    
    "digits"           => ":attribute يجب أن يكون مكونا من :digits رقما.",
    
    "digits_between"   => ":attribute يجب أن يكون بين :min و :max رقما.",
    
    "email"            => ":attribute تنسيق غير صحيح.",
    
    "exists"           => "هذه :attribute المحددة غير صحيحة.",
    
    "image"            => ":attribute يجب أن يكون صورة.",
    
    "in"               => "هذه :attribute المحددة غير صحيحة.",
    
    "integer"          => ":attribute يجب أن يكون عددا.",
    
    "ip"               => ":attribute يجب ان يكون عنوان IP صحيحا.",
    
    "max"              => array(
    
        "numeric" => ":attribute قد لا يكون أكبر من :max.",
    
        "file"    => ":attribute قد لا يكون أكبر من :max kilobytes.",
    
        "string"  => "The :attribute قد يكون أكبر من :max حرفا.",
    
    ),
    
    "mimes"            => ":attribute يجب أن يكون ملف من نوع: :values.",
    
    "min"              => array(
    
        "numeric" => ":attribute يجب أن يكون على الأقل :min.",
    
        "file"    => ":attribute يجب أن يكون على الأقل :min kilobytes.",
    
        "string"  => "The :attribute يجب أن يكون على الأقل :min حرفا.",
    
    ),
    
    "not_in"           => "هذه :attribute المحددة غير صحيحة.",
    
    "numeric"          => ":attribute يجب أن يكون رقما.",
    
    "regex"            => ":attribute شكل أو تنسيق غير صحيح.",
    
    "required"         => ":attribute حقل مطلوب.",
    
    "required_with"    => ":attribute حقل مطلوب عند هذه القيم :values.",
    
    "required_without" => ":attribute حقل مطلوب عند غياب هذه القيم :values .",
    
    "same"             => ":attribute و :other يجب أن تكونا متطابقتين.",
    
    "size"             => array(
    
        "numeric" => ":attribute يجب أن تكون بحجم :size.",
    
        "file"    => ":attribute يجب أن تكون بحجم :size kilobytes.",
    
        "string"  => ":attribute يجب أن يكون مكونا من :size حرفا.",
    
    ),
    
    "unique"           => ":attribute سبق استخدام هذه البيانات.",
    
    "url"              => ":attribute شكل أو تنسيق غير صحيح.",

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
    
            'required' => 'يجب إدخال كلمة السر القديمة.',
    
            'min' => 'يجب أن تكون كلمة السر الخاصة بك مكونة من 6 أحرف على الأقل.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'يجب إدخال كلمة السر الجديدة.',
    
            'min' => 'يجب أن تكون كلمة السر الجديدة الخاصة بك مكونة من 6 أحرف على الأقل.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'يجب تأكيد كلمة السر الجديدة.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'الدقائق يجب أن تكون عددا',
    
            'required' => 'يجب تحديد مدة التعليق بالدقائق',
    
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
