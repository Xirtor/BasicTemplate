<?php

// update user action

use Xirtor\Validation\Validator;

return function ($user_id){
	
	// установка соединения с базой данных
	$this->setDb();

	// поиск пользователя
	$user = User::findById($user_id)->object();
	if (!$user) {
		return $this->view->render('users/update.php', [
			'error' => 'Пользователь не найден']);
	}


	// проверка наличия данных

	if (isset($_POST['name']) || isset($_POST['email'])) {
	

		// валидация
		$validator = new Validator($this->getConfig('validators/updateUser'));
		if (!$validator->validate($_POST)) {
			return $this->view->render('users/update.php', [
				'error' => $validator->errors[0], 
				'user' => $user ]);
		}

		// изменение данных
		$user->name = $validator->values['name'];
		$user->email = $validator->values['email'];

		// обновление данных
		if (!$user->update(['name', 'email'])) {
			return $this->view->render('users/update.php', [
				'error' => 'Не удалось обновить данные', 
				'user' => $user ]);
		}

		$this->view->render('users/update.php', [
				'success' => 'Данные сохранены', 
				'user' => $user]);


	} else if (isset($_POST['password']) && isset($_POST['password_new'])) {

		// валидация
		$validator = new Validator($this->getConfig('validators/updateUserPassword'));
		if (!$validator->validate($_POST)) {
			return $this->view->render('users/update.php', [
				'error' => $validator->errors[0], 
				'user' => $user ]);
		}

		// проверка старого пароля
		$user->password = $validator->values['password'];
		$user->password_new = $validator->values['password_new'];
		if (!$user->passwordVerify()) {
			return $this->view->render('users/update.php', [
				'error' => 'Старый пароль введен не верно', 
				'user' => $user ]);
		}

		// изменение данных
		$user->password_new = $user->password;

		// обновление данных
		if (!$user->update(['password'])) {
			return $this->view->render('users/update.php', [
				'error' => 'Не удалось обновить пароль', 
				'user' => $user ]);
		}

		$this->view->render('users/update.php', [
				'success' => 'Данные сохранены', 
				'user' => $user]);



	} else {

		$this->view->render('users/update.php', ['user' => $user]);

	}

};