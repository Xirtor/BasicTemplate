<?php
/**
* @package Xirtor
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor;

/**
* Classes autoloader
* Support standarts PSR4, PSR0
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Loader{

	protected $_classes = [];
	protected $_namespaces = [];
	protected $_dirs = [];
	protected $_registered = false;

	public function __construct(){
		$this->registerDir('vendor/');
	}

	public function registerClass($name, $path){
		$this->_classes[$name] = $path;
	}

	public function registerClasses(array $classes){
		foreach ($classes as $name => $path) {
			$this->registerClass($name, $path);
		}
	}

	public function registerNamespace($name, $path){
		$this->_namespaces[$name] = $path;
	}

	public function registerNamespaces(array $namespaces){
		foreach ($namespaces as $namespace => $path) {
			$this->registerNamespace($namespace, $path);
		}
	}

	public function registerDir($dir){
		$this->_dirs[] = $dir;
	}

	public function registerDirs(array $dirs){
		foreach ($dirs as $dir) {
			$this->registerDir($dir);
		}
	}

	public function register(){
		if ($this->_registered === false) {
			spl_autoload_register([$this, 'autoload']);
			$this->_registered = true;
		}
	}

	public function unregister(){
		spl_autoload_unregister([$this, 'autoload']);
		$this->_registered = false;
	}

	public function autoload($className){
		$filename = isset($this->_classes[$className]) ? $this->_classes[$className] : false;
		if (!is_readable($filename)) $filename = false;


		if (!$filename) {

			foreach ($this->_namespaces as $name => $path) {
				if (preg_match("/^$name/", $className)) {
					$tmp = $path . $className . '.php';
					if (is_readable($tmp)) {
						$filename = $tmp;
						break;
					}
				}
			}

			if (!$filename) {

				foreach ($this->_dirs as $path) {
					$tmp = $path . $className . '.php';
					if (is_readable($tmp)) {
						$filename = $tmp;
						break;
					}
				}

			}

		}

		if ($filename) require $filename;
	}

}