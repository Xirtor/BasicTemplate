<?php

// create user action

return function (){

	// устанавливаем соединение с базой данных
	$this->setDb();

	// если данные пришли
	if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password'])) {
		
		// добавление пользователя
		$user = new User($_POST);
		$user->passwordToHash();

		if ($user->insert()) {
			// редиректим на просмотр нового пользователя
			header('location: ' . $this->dir . 'users/id' . $user->id);
		} else {
			$this->view->render('users/create.php', ['error' => 'Не удалось добавить пользователя']);
		}

	} else {

		// отрисовка формы добавления пользователя
		$this->view->render('users/create.php');

	}
	
};