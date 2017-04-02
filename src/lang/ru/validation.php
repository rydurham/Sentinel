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
	
	"after"            => ":attribute должен быть датой после :date.",
	
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
	
	"email"            => "Не правильный формат :attribute.",
	
	"exists"           => "Выбранный :attribute не верен.",
	
	"image"            => ":attribute должен быть изображением.",
	
	"in"               => "Выбранный :attribute не верный.",
	
	"integer"          => ":attribute должен быть числом.",
	
	"ip"               => ":attribute должно быть IP-адресом.",
	
	"max"              => array(
	
		"numeric" => ":attribute не должно быть больше чем :max.",
	
		"file"    => ":attribute не должен превышать :max килобайт.",
	
		"string"  => ":attribute не должно превышать :max символов.",
	
	),
	
	"mimes"            => "Тип файла :attribute должен быть: :values.",
	
	"min"              => array(
	
		"numeric" => ":attribute должно быть не менее :min.",
	
		"file"    => ":attribute должно быть не менее :min килобайт.",
	
		"string"  => ":attribute должно быть не менее :min символов.",
	
	),
	
	"not_in"           => "Выбранный :attribute не верный.",
	
	"numeric"          => ":attribute должен быть числом.",
	
	"regex"            => "Не правильный формат :attribute.",
	
	"required"         => ":attribute обязательное поле.",
	
	"required_with"    => ":attribute обязательное поле, когда присутствует :values.",
	
	"required_without" => ":attribute обязательное поле, когда отсутствует :values.",
	
	"same"             => ":attribute и :other должны совпадать.",
	
	"size"             => array(
	
		"numeric" => ":attribute должен быть :size.",
	
		"file"    => ":attribute должен весить :size килобайт.",
	
		"string"  => ":attribute должен состоять из :size символов.",
	
	),
	
	"unique"           => ":attribute уже занят.",
	
	"url"              => "Не правильный формат :attribute.",

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
    
            'numeric' => 'Минуты должны быть числом',
    
            'required' => 'Вы должны указать длину блокировки в минутах',
    
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
