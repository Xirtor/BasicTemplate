<?php

// create user validator config

return [

	'inputs' => [
		'name' => [
			'label' => 'Имя',
			'type' => 'string',
			'min' => 4,
			'max' => 30,
			'pattern' => '/^[a-zA-Z0-9_-]*$/',
			'moreThatMinError' => 'Имя пользователя должно быть длиной от 4 до 30 символов',
			'lessThatMaxError' => 'Имя пользователя должно быть длиной от 4 до 30 символов',
			'patternIncorrectError' => 'Имя пользователя может содержать английские буквы, цифры, нижнее подчеркивание и тире'
		],
		'email' => [
			'label' => 'Email',
			'type' => 'string',
			'min' => 8,
			'max' => 60,
			'pattern' => '/^.{2,}@.{2,}\..{2,16}$/',
			'moreThatMinError' => 'Email должен быть длиной от 4 до 30 символов',
			'lessThatMaxError' => 'Email должен быть длиной от 4 до 30 символов',
			'patternIncorrectError' => 'Проверьте правильность email'
		],
		'password' => [
			'label' => 'Пароль',
			'type' => 'string',
			'min' => 4,
			'max' => 30,
			'moreThatMinError' => 'Пароль должен быть длиной от 4 до 30 символов',
			'lessThatMaxError' => 'Пароль должен быть длиной от 4 до 30 символов',
		]
	]

];

?>