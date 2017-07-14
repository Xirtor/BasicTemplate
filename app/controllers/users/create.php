<?php

// create user action

return function (){

	// устанавливаем соединение с базой данных
	$this->setDb();

	// тестовые данные
	$userdata = [
		'name' => 'test',
		'email' => 'test@test.test',
		'password' => '1234'
	];

	// добавление пользователя
	$user = new User($userdata);
	$user->passwordToHash();
	echo ( $user->insert() ? 'success' : 'fail' ) . ' insert user';
	
};