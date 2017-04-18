<?php
/**
* @package Xirtor Forms
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Forms;

/**
* Form Field
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Field{

	// Error patterns;
	public static $patterns = [
		'emptyField' => '"Field \"$this->name\" is empty"',
		'smallLength' => '"The length of the field \"$this->name\" must be more than $this->min"',
		'longLength' => '"The length of the field \"$this->name\" must be less than $this->max"',
		'smallNumber' => '"The value of the field \"$this->name\" must be more than $this->min"',
		'bigNumber' => '"The value of the field \"$this->name\" must be less than $this->max"',
		'patternError' => '"Field \"$this->name\" have incorrect value"'
	];

	public $error;

	public $type;

	public $name;
	public $value;

	public $min;
	public $max;
	public $regExp;
	public $require = false;

	public static function setErrorPatterns(array $patterns){
		$this->errorPatterns = $patterns;
	}

	public function __construct($type, $name){
		$this->type = $type;
		$this->name = $name;
	}

	public function min($value){
		$this->min = $value;
		return $this;
	}

	public function max($value){
		$this->max = $value;
		return $this;
	}

	public function regExp($value){
		$this->regExp = $value;
		return $this;
	}

	public function required(){
		$this->require = true;
	}

	public function dropRequired(){
		$this->require = false;
	}

	public function errorHandler($messageKey){
		$this->error = eval('return ' . static::$patterns[$messageKey] . ';');
		return false;
	}

	public function validate($value){
		$this->value = $value;
		if ($this->require && empty($value)) {
		}
		if (empty($value)) {
			if ($this->require) return $this->errorHandler('emptyField');
			else return true;
		}
		if ($this->type == 'string'){
			$length = mb_strlen($value);
			if (isset($this->min) && $length < $this->min) return $this->errorHandler('smallLength');
			if (isset($this->max) && $length > $this->max) return $this->errorHandler('longLength');
		} else if ($this->type == 'number') {
			if (isset($this->min) && $value < $this->min) return $this->errorHandler('smallNumber');
			if (isset($this->max) && $value > $this->max) return $this->errorHandler('bigNumber');
		}

		if (isset($this->regExp) && !preg_match($this->regExp, $value)) return $this->errorHandler('patternError');

		return true;
	}

}