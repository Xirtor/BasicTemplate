<?php

// create user action

use Xirtor\Validation\Validator;

return function (){

	// проверка наличия данных
	if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password'])) {
		// если данные не пришли отрисовываем форму добавления пользователя
		return $this->view->render('users/create.php');
	}

	// валидация
	$validator = new Validator($this->getConfig('validators/createUser'));
	if (!$validator->validate($_POST)) {
		// если валидация не прошла рендерим форму с текстом ошибки над ней
		return $this->view->render('users/create.php', [
			'error' => $validator->errors[0], 
			'user' => (object) $validator->values]);
	}

	// установка соединения с базой данных
	$this->setDb();
		
	// создание пользователя
	$user = new User($validator->values);
	$user->passwordToHash();

	// добавление пользователя
	if (!$user->insert()) {
		// если не удалось добавить пользователя рендерим форму с текстом ошибки над ней
		return $this->view->render('users/create.php', [
			'error' => 'Не удалось добавить пользователя', 
			'user' => $user]);
	}

	// редиректим на просмотр нового пользователя
	header('location: ' . $this->dir . 'users/' . $user->id);
	
};