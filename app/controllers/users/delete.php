<?php

// delete user action

return function ($user_id){
	
	// устанавливаем соединение с базой
	$this->setDb();

	// поиск пользователя
	$user = User::findById($user_id)->object();
	if (!$user) {
		return $this->view->render('users/delete.php', [
			'error' => 'Пользователь не найден']);
	}

	// удаляем пользователя
	if (!$user->delete()) {
		return $this->view->render('users/delete.php', [
			'error' => 'Не удалось удалить пользователя', 
			'user' => $user]);
	}

	$this->view->render('users/delete.php', [
			'success' => 'Пользователь удален', 
			'user' => $user]);

};