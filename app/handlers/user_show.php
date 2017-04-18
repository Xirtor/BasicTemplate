<?php

return function ($id){
	
	$user = User::find()->where('id = ' . $id)->one()->object();

	var_dump($user);

};