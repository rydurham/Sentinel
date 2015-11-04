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

    "accepted"         => "Các :thuộc tính phải được chấp nhận.",
    
    "active_url"       => "Các :attribute không phải là một URL hợp lệ.",
    
    "after"            => "Các :attribute phải là một ngày sau khi :date.",
    
    "alpha"            => ":attribute chỉ có thể chứa các chữ cái.",
    
    "alpha_dash"       => ":attribute có thể chỉ chứa chữ, số và dấu phẩy.",
    
    "alpha_num"        => ":attribute chỉ có thể chứa các chữ cái và số.",

    "alpha_spaces"     => ":attribute chỉ có thể chứa các chữ cái và cách khoản.",
    
    "before"           => ":attribute phải là một ngày trước :date.",
    
    "between"          => array(
    
        "numeric" => ":attribute phải nằm giữa :min - :max.",
    
        "file"    => ":attribute phải nằm giữa :min - :max kilobytes.",
    
        "string"  => ":attribute phải nằm :min - :max ký tự.",
    
    ),
    
    "confirmed"        => ":attribute xác nhận không đúng.",
    
    "date"             => ":attribute có ngày không hợp lý.",
    
    "date_format"      => ":attribute không phù hợp định dạng :format.",
    
    "different"        => ":attribute và :other phải khác nhau.",
    
    "digits"           => ":attribute phải có :digits số.",
    
    "digits_between"   => ":attribute phải ở giữa :min và :max số.",
    
    "email"            => "Định dạng :attribute thì không phù hợp.",
    
    "exists"           => ":attribute đã lựa chọn không hợp lý.",
    
    "image"            => ":attribute phải là một hình.",
    
    "in"               => ":attribute đã chọn không phù hợp.",
    
    "integer"          => ":attribute phải là một số nguyên.",
    
    "ip"               => ":attribute phải là một địa chỉ IP.",
    
    "max"              => array(
    
        "numeric" => ":attribute có thể không lớn hơn :max.",
    
        "file"    => ":attribute có thể không lớn hơn :max kilobytes.",
    
        "string"  => ":attribute có thể không lớn hơn :max ký tự.",
    
    ),
    
    "mimes"            => ":attribute phải là một tập tin có phần mở rộng là: :values.",
    
    "min"              => array(
    
        "numeric" => ":attribute phải có ít nhất :min.",
    
        "file"    => ":attribute phải ít nhất :min kilobytes.",
    
        "string"  => ":attribute phải ít nhất :min ký tự.",
    
    ),
    
    "not_in"           => ":attribute đã chọn không phù hợp.",
    
    "numeric"          => ":attribute phải là một số.",
    
    "regex"            => "Định dạng :attribute không phù hợp.",
    
    "required"         => "Trường :attribute là bắt buộc.",
    
    "required_with"    => "Trường :attribute là bắt buộc khi :values là hiện tại.",
    
    "required_without" => "Trường :attribute là bắt buộc khi :values là không hiện tại.",
    
    "same"             => ":attribute và :other phải giống nhau.",
    
    "size"             => array(
    
        "numeric" => ":attribute phải có cỡ :size.",
    
        "file"    => ":attribute phải có cỡ :size kilobytes.",
    
        "string"  => ":attribute phải có :size ký tự.",
    
    ),
    
    "unique"           => ":attribute đã sẵn sàng.",
    
    "url"              => "Định dạng :attribute là không hợp lý.",

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
    
            'required' => 'Bạn phải nhập mật khẩu cũ của bạn.',
    
            'min' => 'Mật khẩu của bạn phải dài ít nhất 6 ký tự.',
    
        ),
    
        'newPassword' => array(
    
            'required' => 'Bạn phải nhập mật khẩu mới.',
    
            'min' => 'Mật khẩu của bạn phải dài ít nhất 6 ký tự.',
    
        ),
    
        'newPassword_confirmation' => array(
    
            'required' => 'Bạn phải xác nhận mật khẩu mới của bạn.',
    
        ),
    
        'minutes' => array(
    
            'numeric' => 'Phút phải là một số',
    
            'required' => 'Bạn phải xác định thời gian đình chỉ trong vài phút',
    
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
