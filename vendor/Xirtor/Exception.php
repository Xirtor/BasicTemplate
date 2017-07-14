<?php
/**
* @package Xirtor
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor;

/**
* Exception class
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Exception extends \Exception{

	public function __construct($message, $code = 0, Exception $previous = null){
		echo $message = 'Xirtor catch exception: ' . $message;
		parent::__construct($message, $code, $previous);
	}

}