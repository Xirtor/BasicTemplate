<?php

// routes config

return [
	'GET' => [
		'/' => function (){
			echo 'Home page';
		},
		'/auth' => 'auth',
		'/registration' => 'registration',
		'/user/show/(:num)' => 'user_show'
	]
];