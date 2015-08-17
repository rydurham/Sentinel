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

    "accepted"         => ":attribute 是被接受的",
    
    "active_url"       => ":attribute 必須是一個合法的 URL",
    
    "after"            => ":attribute 必須是 :date 之後的一個日期",
    
    "alpha"            => ":attribute 必須全部由字母字元構成",
    
    "alpha_dash"       => ":attribute 必須全部由字母、數字、中劃線或下劃線字元構成",
    
    "alpha_num"        => ":attribute 必須全部由字母和數字構成",

    "alpha_spaces"     => ":attribute 必須全部由字母和空格構成",
    
    "before"           => ":attribute 必須是 :date 之前的一個日期",
    
    "between"          => array(
    
        "numeric" => ":attribute 必須在 :min 到 :max 之間",
    
        "file"    => ":attribute 必須在 :min 到 :max KB之間",
    
        "string"  => ":attribute 必須在 :min 到 :max 個字元之間",
    
    ),
    
    "confirmed"        => ":attribute 二次確認不匹配",
    
    "date"             => ":attribute 必須是一個合法的日期",
    
    "date_format"      => ":attribute 與給定的格式 :format 不符合",
    
    "different"        => ":attribute 必須不同於 :other",
    
    "digits"           => ":attribute 必須是 :digits 位",
    
    "digits_between"   => ":attribute 必須在 :min 到 :max 位之間",
    
    "email"            => ":attribute 必須是一個合法的電子郵件地址",
    
    "exists"           => "選定的 :attribute 是無效的",
    
    "image"            => ":attribute 必須是一個圖片",
    
    "in"               => "選定的 :attribute 是無效的",
    
    "integer"          => ":attribute 必須是個整數",
    
    "ip"               => ":attribute 必須是一個合法的 IP 地址",
    
    "max"              => array(
    
        "numeric" => ":attribute 的最大長度為 :max 位",
    
        "file"    => ":attribute 的最大長度為 :max KB",
    
        "string"  => ":attribute 的最大長度為 :max 字元",
    
    ),
    
    "mimes"            => ":attribute 的文件類型必須是 :values",
    
    "min"              => array(
    
        "numeric" => ":attribute 的最小長度為 :min 位",
    
        "file"    => ":attribute 大小至少為 :min KB",
    
        "string"  => ":attribute 的最小長度為 :min 字元",
    
    ),
    
    "not_in"           => "選定的 :attribute 是無效的",
    
    "numeric"          => ":attribute 必須是數字",
    
    "regex"            => ":attribute 格式是無效的",
    
    "required"         => ":attribute 欄位是必填的",
    
    "required_with"    => "當 :values 是存在時，:attribute 欄位是必填的。",
    
    "required_without" => "當 :values 是不存在時，:attribute 欄位是必須的。",
    
    "same"             => ":attribute 和 :other 必須匹配",
    
    "size"             => array(
    
        "numeric" => ":attribute 必須是 :size 位",
    
        "file"    => ":attribute 必須是 :size KB",
    
        "string"  => ":attribute 必須是 :size 個字元",
    
    ),
    
    "unique"           => ":attribute 已存在",
    
    "url"              => ":attribute 無效的格式",

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
    
            'required' => '您必須填入您的舊密碼',
    
            'min' => '您的舊密碼應該至少要有 6個字元長度',
    
        ),
    
        'newPassword' => array(
    
            'required' => '您必須填入一組新密碼',
    
            'min' => '您的新密碼應該至少要有 6個字元長度',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => '您必須確認您的新密碼',
    
        ),
    
        'minutes' => array(
    
            'numeric' => '分鐘必須是一個數位',
    
            'required' => '您必須指定分鐘長度',
    
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
