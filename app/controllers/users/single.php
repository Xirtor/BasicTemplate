<?php

// show single user action

return function ($user_id){

	// устанавливаем соединение с базой данных
	$this->setDb();

	// получаем пользователя
	$user = User::find()->where('=', 'id', $user_id)->one()->object();
	
	if ($user) {
		$this->view->render('users/single.php', ['user' => $user]);
	} else {
		$this->view->render('page.php', ['title' => '404. Not Found.', 'content' => 'Not found user']);
	}
	
};