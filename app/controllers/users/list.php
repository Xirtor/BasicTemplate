<?php

// users list action

return function (){

	// устанавливаем соединение с базой данных
	$this->setDb();

	// получаем список пользователей
	$users = User::find()->limit(10)->get()->objects();

	if ($users) {
		$this->view->render('users/list.php', ['title' => 'Users', 'users' => $users]);
	} else {
		$this->view->render('page.php', ['title' => '404. Not Found.', 'content' => 'Not found users']);
	}

};