<?php

// show single user action

return function ($user_id){

	// устанавливаем соединение с базой данных
	$this->setDb();

	// получаем пользователя
	$user = User::find()->where('=', 'id', $user_id)->one()->objects();
	
	if ($user) {
		var_dump($user);
	}
	
};