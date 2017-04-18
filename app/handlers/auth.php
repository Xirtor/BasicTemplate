<?php

return function (){
	
	$errors = [];
	$token = false;

	// Валидация
	$form = new Xirtor\Forms\Form;
	$form->createField('string', 'username')->min(4)->max(15);
	$form->createField('string', 'email')->min(8)->max(60)->regExp('/^.*@.{2,}\..{2,8}/');
	$form->createField('string', 'password')->min(4)->max(15)->required();

	if (!$form->validate($_GET)) {
		$errors = $form->errors;
	} else {
		// Пользователь для авторизации
		$user = new Xirtor\Auth\User($form->values);
		
		// Авторизация
		$user->auth()->in();
			
		$errors = [$user->auth()->error];

		if ($user->auth()->is()) {
			$token = $user->auth()->session->token;
			// Тут можно что-то сделать
		}
	}

	echo json_encode(['errors' => $errors, 'token' => $token]);


};