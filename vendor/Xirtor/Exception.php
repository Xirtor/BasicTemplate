<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor;

/**
* Exception class
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class Exception extends \Exception{
	
	public function __construct($message, $code = 0, Exception $previous = null){
		// die ('Xirtor catch exception: ' . $message);
		// echo $message = 'Xirtor catch exception: ' . $message;
		parent::__construct($message, $code, $previous);
	}

}