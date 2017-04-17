<?php

// Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload
require 'vendor/Xirtor/Loader.php';
$loader = new Xirtor\Loader;
$loader->register();

// Logger
$logger = new Xirtor\Logger('log.txt');
$logger->write('hello');


// Micro application example


// create application
$app = new Xirtor\Web\Micro;

// callback handler
$app->get('/', function (){
	echo 'Home page';
});

// handler in file
$app->get('/auth', 'app/handlers/auth');
$app->get('/registration', 'app/handlers/registration');

$app->handle();