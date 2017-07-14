<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Web;

use Xirtor\Di;
use Xirtor\Exception;
use Xirtor\Web\Router;
use Xirtor\Web\View;
use Xirtor\Orm\Connection;
use Xirtor\Web\Model;

/**
* Application
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class App extends Di{
	
	public $dir;
	public $url;
	public $path;
	public $parts;

	public $router;
	public $view;
	public $db;

	public $config;
	public $configDir = 'app/config/';
	public $controllersDir = 'app/controllers/';
	public $viewsDir = 'app/views/';

	public function getConfig($name){
		if (isset($this->config[$name])) return $this->config[$name];
		$filename = $this->configDir . $name . '.php';
		if (is_readable($filename)) return $this->config[$name] = include $filename;
	}

	public function init(){
		$this->getConfig('app');
		$this->_parseUrl();
	}

	protected function _parseUrl(){
		$slash = strrpos($_SERVER['PHP_SELF'], '/index.php');
		$this->dir = substr($_SERVER['PHP_SELF'], 0, $slash + 1);
		$this->url = substr($_SERVER['REQUEST_URI'], $slash);
		$this->path = parse_url($this->url, PHP_URL_PATH);
		$this->parts = explode('/', substr($this->path, 1));
	}

	public function setRouter(array $config = null){
		if (!$config) $config = $this->getConfig('router');
		$this->router = new Router($config);
	}

	public function setView(){
		$this->view = new View($this);
	}

	public function setDb(array $config = null){
		if (!$config) $config = $this->getConfig('db');
		$this->db = new Connection($config);
		$this->db->open();
		Model::$db = &$this->db;
	}

	public function handle($route = null){
		if (!$route) $route = $this->router->handle($this->url);

		// если (функция) колбек
		if (is_callable($route->handler)) {
			$handler = $route->handler->bindTo($this);
		}
		// если статик метод класса
		else if (is_array($route->handler) && count($route->handler) === 2) {
			$handler = &$route->handler;
		}
		// если (строка) путь к файлу
		else if (is_string($route->handler)) {
			$filename = $this->controllersDir . $route->handler;
			if (is_readable($filename)) {
				$handler = include $filename;
				if (!is_callable($handler)) {
					extract($route->matches);
					return;
				}
			}
		}

		if (isset($handler)) return call_user_func_array($handler, $route->matches);
		else if ($this->router->notFound) return $this->handle(new Route($this->router->notFound, null));
		else throw new Exception('Application error: 404. Not Found.');
	}

}