<?php

// Вывод ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Автозагрузчик классов
require 'vendor/Xirtor/Loader.php';
$loader = new Xirtor\Loader;
$loader->register();

// Менеджер журнала
$logger = new Xirtor\Logger('log.txt');
$logger->write('hello');
