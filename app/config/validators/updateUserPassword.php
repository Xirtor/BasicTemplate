<?php

// update user password validator config

return [

	'inputs' => [
		'password' => [
			'label' => 'Пароль',
			'type' => 'string',
			'min' => 4,
			'max' => 30,
			'moreThatMinError' => 'Пароль должен быть длиной от 4 до 30 символов',
			'lessThatMaxError' => 'Пароль должен быть длиной от 4 до 30 символов',
		],
		'password_new' => [
			'label' => 'Новый пароль',
			'type' => 'string',
			'min' => 4,
			'max' => 30,
			'moreThatMinError' => 'Новый пароль должен быть длиной от 4 до 30 символов',
			'lessThatMaxError' => 'Новый пароль должен быть длиной от 4 до 30 символов',
		]
	]

];

?>