<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used
	| by the validator class. Some of the rules contain multiple versions,
	| such as the size (max, min, between) rules. These versions are used
	| for different input types such as strings and files.
	|
	| These language lines may be easily changed to provide custom error
	| messages in your application. Error messages for custom validation
	| rules may also be added to this file.
	|
	*/

	"accepted"       => "Вы должны принять :attribute.",
	"active_url"     => "Поле :attribute должно быть полным URL.",
	"after"          => "Поле :attribute должно быть датой после :date.",
	"alpha"          => "Поле :attribute может содержать только буквы.",
	"alpha_dash"     => "Поле :attribute может содержать только буквы, цифры и тире.",
	"alpha_num"      => "Поле :attribute может содержать только буквы и цифры.",
	"array"          => "Поле :attribute должно быть списком.",
	"before"         => "Поле :attribute должно быть датой перед :date.",
	"between"        => array(
		"numeric" => "Поле :attribute должно быть между :min и :max.",
		"file"    => "Поле :attribute должно быть от :min до :max Килобайт.",
		"string"  => "Поле :attribute должно быть от :min до :max символов.",
	),
	"confirmed"      => "Поле :attribute не совпадает с подтверждением.",
	"count"          => "Поле :attribute должно содержать :count элементов.",
	"countbetween"   => "Поле :attribute должно содержать от :min до :max элементов.",
	"countmax"       => "Поле :attribute не должно содержать больше чем :max элементов.",
	"countmin"       => "Поле :attribute не должно содержать меньше чем :min элементов.",
	"date_gt"        => "Поле :attribute должно быть больше чем :other.",
	"date_lt"        => "Поле :attribute должно быть меньше чем :other.",
	"different"      => "Поля :attribute и :other должны различаться.",
	"email"          => "Поле :attribute имеет неверный формат.",
	"exists"         => "Выбранное значение для :attribute уже существует.",
	"gt"             => "Поле :attribute должно быть больше чем :other.",
	"image"          => "Поле :attribute должно быть картинкой.",
	"in"             => "Выбранное значение для :attribute не верно.",
	"integer"        => "Поле :attribute должно быть целым числом.",
	"ip"             => "Поле :attribute должно быть полным IP-адресом.",
	"lt"             => "Поле :attribute должно быть меньше чем :other.",
	"match"          => "Поле :attribute имеет неверный формат.",
	"max"            => array(
		"numeric" => "Поле :attribute должно быть меньше :max.",
		"file"    => "Поле :attribute должно быть меньше :max Килобайт.",
		"string"  => "Поле :attribute должно быть короче :max символов.",
	),
	"mimes"          => "Поле :attribute должно быть файлом одного из типов: :values.",
	"min"            => array(
		"numeric" => "Поле :attribute должно быть не менее :min.",
		"file"    => "Поле :attribute должно быть не менее :min Килобайт.",
		"string"  => "Поле :attribute должно быть не короче :min символов.",
	),
	"not_in"         => "Выбранное значение для :attribute не верно.",
	"numeric"        => "Поле :attribute должно быть числом.",
	"required"       => "Поле :attribute обязательно для заполнения.",
	"same"           => "Значение :attribute должно совпадать с :other.",
	"size"           => array(
		"numeric" => "Поле :attribute должно быть :size.",
		"file"    => "Поле :attribute должно быть :size Килобайт.",
		"string"  => "Поле :attribute должно быть длиной :size символов.",
	),
	"unique"         => "Такое значение поля :attribute уже существует.",
	"unique_with"    => "Такое значение поля :attribute уже существует.",
	"url"            => "Поле :attribute имеет неверный формат.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute_rule" to name the lines. This helps keep your
	| custom validation clean and tidy.
	|
	| So, say you want to use a custom validation message when validating that
	| the "email" attribute is unique. Just add "email_unique" to this array
	| with your custom message. The Validator will handle the rest!
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". Your users will thank you.
	|
	| The Validator class will automatically search this array of lines it
	| is attempting to replace the :attribute place-holder in messages.
	| It's pretty slick. We think you'll like it.
	|
	*/

	'attributes' => array(),

);
