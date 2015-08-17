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

    "accepted"         => " :attribute 必须是可以接受的",
    
    "active_url"       => ":attribute 不是一个有效的URL网址",
    
    "after"            => ":attribute 必须是后的一个日期。",
    
    "alpha"            => ":attribute 只能包含字母",
    
    "alpha_dash"       => ":attribute 只能包含字母，数字和破折号",
    
    "alpha_num"        => ":attribute 只允许包含字母和数字",

    "alpha_spaces"     => ":attribute 只允许包含字母和数字",
    
    "before"           => ":attribute 必须在 :date 之前",
    
    "between"          => array(
    
        "numeric" => ":attribute 必须在 :min - :max 之间",
    
        "file"    => ":attribute 必须在 :min - :max kb 之间",
    
        "string"  => ":attribute 必须在 :min - :max 字符之间",
    
    ),
    
    "confirmed"        => ":attribute 与确认项目不匹配",
    
    "date"             => ":attribute 不是个有效日期",
    
    "date_format"      => ":attribute 不符合 :format 的格式",
    
    "different"        => " :attribute 和 :other 不能相同",
    
    "digits"           => ":attribute 必须是  :digits  数字",
    
    "digits_between"   => ":attribute 必须在 :min 和 :max 数字之间",
    
    "email"            => ":attribute 的格式无效",
    
    "exists"           => "选择的 :attribute 无效",
    
    "image"            => ":attribute 必须是图片",
    
    "in"               => "选择的 :attribute 无效",
    
    "integer"          => ":attribute 必须是整数",
    
    "ip"               => ":attribute 必须是一个有效的 IP 地址",
    
    "max"              => array(
    
        "numeric" => ":attribute 不大于 :max",
    
        "file"    => ":attribute 不大于 :max kb",
    
        "string"  => ":attribute 不大于 :max 字符",
    
    ),
    
    "mimes"            => ":attribute 文件类型必须是 :values",
    
    "min"              => array(
    
        "numeric" => ":attribute 最少是  :min",
    
        "file"    => ":attribute 最小 :min kb",
    
        "string"  => ":attribute 最少为 :min个字符",
    
    ),
    
    "not_in"           => "选择的 :attribute 无效",
    
    "numeric"          => ":attribute 必须是数字",
    
    "regex"            => ":attribute 的格式无效",
    
    "required"         => ":attribute 字段必填",
    
    "required_with"    => " 当 :values 不存在时， :attribute 是必需的",
    
    "required_without" => " 当 :values 不存在时， :attribute 是必需的",
    
    "same"             => ":attribute 和 :other  必需匹配",
    
    "size"             => array(
    
        "numeric" => ":attribute 必须是  :size",
    
        "file"    => ":attribute 必须是 :size KB大小",
    
        "string"  => ":attribute必须是： :size characters大小的字符",
    
    ),
    
    "unique"           => ":attribute 已经被占用",
    
    "url"              => ":attribute 的格式无效",

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
    
            'required' => '您必须输入您的旧密码',
    
            'min' => '您的旧密码必须至少 6 个字符长',
    
        ),
    
        'newPassword' => array(
    
            'required' => '您必须输入一个新密码',
    
            'min' => '您的新密码必须至少 6 个字符长',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => '您必须确认您的新密码',
    
        ),
    
        'minutes' => array(
    
            'numeric' => '分钟必须是一个数字',
    
            'required' => '您必须指定分钟数',
    
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
