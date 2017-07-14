<?php

// users list action

return function (){

	// устанавливаем соединение с базой данных
	$this->setDb();

	// получаем список пользователей
	$users = User::find()->limit(10)->get()->objects();
	
	if ($users) {
		var_dump($users);
	}

};