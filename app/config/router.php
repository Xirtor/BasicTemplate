<?php

// router config

return [

	'notFound' => '404.php',

	'routes' => [

		'GET' => [

			'/' => 'index.php',
			'/users' => 'users/list.php',
			'/users/id(:int)' => 'users/single.php'

		]

	]

];