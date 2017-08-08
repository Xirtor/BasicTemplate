<?php

// вывод ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {

	// автозагрузка классов
	include 'vendor/Xirtor/Loader.php';
	$loader = new Xirtor\Loader;
	$loader->registerDir('app/models/');
	$loader->register();

	// создание приложения
	$app = new Xirtor\Web\App;

	// устанавка маршрутизатора
	$app->setRouter();

	// установка класса представлений
	$app->setView();

	// запуск приложения
	$app->run();

} catch (Exception $e) {
	echo 'Xirtor catch exception: ' . $e->getMessage();
}