<?php

// router config

return [

	'notFound' => '404.php',

	'routes' => [

		'GET' => [

			'/' => 'index.php',
			'/users' => 'users/list.php',
			'/users/(:int)' => 'users/single.php',
			'/users/(:int)/edit' => 'users/update.php',
			'/users/create' => 'users/create.php',
			'/users/(:int)/delete' => 'users/delete.php',

		],

		'POST' => [

			'/users/(:int)/edit' => 'users/update.php',
			'/users/create' => 'users/create.php'

		]

	]

];