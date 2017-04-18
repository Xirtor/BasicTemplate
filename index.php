<?php

// Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload
require 'vendor/Xirtor/Loader.php';
$loader = new Xirtor\Loader;
$loader->registerDir('app/models/');
$loader->register();

// Logger
$logger = new Xirtor\Logger('log.txt');
$logger->write('hello');


// Database
$config = require 'app/config/db.php';
$db = new Xirtor\Db\Connection($config);
$db->open();

Xirtor\Web\Model::$db = &$db;


// Micro application example


// create application
$app = new Xirtor\Web\Micro;

// set handlers directory
$app->handlersDir = 'app/handlers/';

// set not found handler
$app->router->notFound = '404';

// import routes handlers from config
$routes = require 'app/config/routes.php';
$app->router->import($routes);

// run application
$app->handle();