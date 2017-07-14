<?php

return function ($id){

	// access controll

	// form validate
	$form = new Xirtor\Forms\Form;
	$form->createField('string', 'title')->min(2)->max(60)->required();
	$form->createField('string', 'preview')->min(2)->max(120);
	$form->createField('string', 'content')->min(2)->max(8000)->required();

	if (!$form->validate($_GET)) {
		var_dump($form->errors);
		return false;
	}

	$article = new Article($form->values);
	$article->update();

};