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

    "accepted"         => ":attribute трябва да бъде избран.",
    
    "active_url"       => ":attribute не е валиден URL.",
    
    "after"            => ":attribute трябва де дата след :date.",
    
    "alpha"            => ":attribute може да съдържа само букви.",
    
    "alpha_dash"       => ":attribute може да съдържа само букви, числа и тирета.",
    
    "alpha_num"        => ":attribute може да съдържа само букви и числа.",

    "alpha_spaces"     => "The :attribute may only contain letters and spaces.",
    
    "before"           => ":attribute  трябва де дата преди :date.",
    
    "between"          => array(
    
        "numeric" => ":attribute трябва де е между :min - :max.",
    
        "file"    => ":attribute трябва де е между :min - :max килобайта.",
    
        "string"  => ":attribute трябва де е между :min - :max знака.",
    
    ),
    
    "confirmed"        => "Потвържденито на :attribute не съвпада.",
    
    "date"             => ":attribute не е валидна дата.",
    
    "date_format"      => ":attribute не е в посоченият формат - :format.",
    
    "different"        => ":attribute и :other трябва да са различни.",
    
    "digits"           => ":attribute трябва да е :digits цифри.",
    
    "digits_between"   => ":attribute трябва да бъде между :min и :max цифри.",
    
    "email"            => ":attribute е с невалиден формат.",
    
    "exists"           => "Избраният :attribute е невалиден.",
    
    "image"            => ":attribute трябва де изображение.",
    
    "in"               => "Избраният :attribute е невалиден.",
    
    "integer"          => ":attribute трябва да е целочислен",
    
    "ip"               => ":attribute трябва да бъде валиден IP адрес.",
    
    "max"              => array(
    
        "numeric" => ":attribute не бива де е по-голям от :max.",
    
        "file"    => ":attribute не бива де е по-голям от :max килобайта.",
    
        "string"  => ":attribute не бива де е по-голям от :max знака.",
    
    ),
    
    "mimes"            => ":attribute трябва да бъде от следният тип: :values.",
    
    "min"              => array(
    
        "numeric" => ":attribute не бива да бъде по-малко от :min.",
    
        "file"    => ":attribute не бива да бъде по-малко от :min килобайта.",
    
        "string"  => ":attribute не бива да бъде по-малко от :min знака.",
    
    ),
    
    "not_in"           => "Изборът на :attribute е невалиден.",
    
    "numeric"          => ":attribute трябва де е число.",
    
    "regex"            => ":attribute е с невалиден формат.",
    
    "required"         => ":attribute е задължетелно поле.",
    
    "required_with"    => ":attribute е задължително когато :values присъства.",
    
    "required_without" => ":attribute е задължително когато :values не присъства.",
    
    "same"             => ":attribute и :other са еднакви.",
    
    "size"             => array(
    
        "numeric" => ":attribute трябва да бъде точно :size.",
    
        "file"    => ":attribute трябва да бъде точно :size килобайта.",
    
        "string"  => ":attribute трябва да бъде точно :size знака.",
    
    ),
    
    "unique"           => ":attribute е вече зает.",
    
    "url"              => ":attribute е с невалиден формат.",

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
    
            'required' => 'Трябва да въведете старата си парола.',
    
            'min' => 'Вашият стар Паролата трябва да съдържа поне 6 символа.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'Трябва да въведете нова парола.',
    
            'min' => 'Вашата нова парола трябва да е с дължина най-малко 6 символа.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'Трябва да потвърдите вашата нова парола.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'Минути трябва да е число',
    
            'required' => 'Трябва да укажете продължителност суспензия в минута',
    
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
