<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor;

use Xirtor\Exception;

/**
* Classes autoloader
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class Loader{

	public $classes = [];
	public $namespaces = [];
	public $dirs = [];
	public $registered = false;

	public function __construct(){
		$this->registerDir('vendor/');
	}

	public function registerClass($name, $path){
		$this->classes[$name] = $path;
	}

	public function registerNamespace($name, $path){
		$this->namespaces[$name] = $path;
	}

	public function registerNamespaces(array $namespaces){
		foreach ($namespaces as $name => $path) {
			$this->registerNamespace($name, $path);
		}
	}

	public function registerDir($dir){
		$this->dirs[] = $dir;
	}

	public function registerDirs(array $dirs){
		foreach ($dirs as $dir) {
			$this->registerDir($dir);
		}
	}

	public function register(){
		spl_autoload_register([$this, 'autoload']);
		$this->registered = true;
	}

	public function unregister(){
		spl_autoload_unregister([$this, 'autoload']);
		$this->registered = false;
	}

	public function autoload($className){
		$className = str_replace('\\', '/', $className);

		if (isset($this->classes[$className])) {
			$filename = $this->classes[$className];
			if (is_readable($filename)) return include $filename;
		}
		foreach ($this->namespaces as $name => $path) {
			if (strpos($className, $name) === 0) {
				$filename = $path . $className . '.php';
				if (is_readable($filename)) return include $filename;
			}
		}
		foreach ($this->dirs as $dir) {
			$filename = $dir . $className . '.php';
			if (is_readable($filename)) return include $filename;
		}
		throw new Exception('Could not found class "' . str_replace('/', '\\', $className) . '"');
	}

}