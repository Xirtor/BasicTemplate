<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Validation;

use Xirtor\Object;

/**
* Input validator
* php7 and more only
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class InputValidator extends Object{
	
	public $label;

	public $type;
	public $typeIncorrectError;

	public $min;
	public $max;
	public $moreThatMinError;
	public $lessThatMaxError;

	public $pattern;
	public $patternIncorrectError;

	public $error;

	public function checkLength($value){
		$length = mb_strlen($value);
		if (isset($this->min) && $length < $this->min) {
			$this->error = $this->moreThatMinError ?? 'length of "'. $this->label . '" must be more that ' . $this->min;
			return false;
		}
		else if (isset($this->max) && $length > $this->max) {
			$this->error = $this->lessThatMaxError ?? 'length of "'. $this->label . '" must be less that ' . $this->max;
			return false;
		}
		else return true;
	}

	public function checkRange($value){
		if (isset($this->min) && $value < $this->min) {
			$this->error = $this->moreThatMinError ?? 'value of "' . $this->label . '" must be more that ' . $this->min;
			return false;
		}
		else if (isset($this->max) && $value > $this->max) {
			$this->error = $this->lessThatMaxError ?? 'value of "' . $this->label . '" must be less that ' . $this->max;
			return false;
		}
		else return true;
	}

	public function checkType($value){
		if ($this->type === 'string' && !is_string($value) ||
			($this->type === 'number' || $this->type === 'float') && !is_numeric($value) ||
			($this->type === 'int' || $this->type === 'integer') && !is_integer($value)) {
			$this->error = $this->typeIncorrectError ?? 'value of "' . $this->label . '" failed type';
			return false;
		}
		return true;
	}

	public function checkPattern($value){
		if (!empty($this->pattern) && !preg_match($this->pattern, $value)) {
			$this->error = $this->patternIncorrectError ?? 'value of "' . $this->label . '" failed pattern';
			return false;
		}
		return true;
	}

	public function validate($value){

		if (
			!$this->checkType($value) ||
			is_string($value) && !$this->checkLength($value) ||
			is_numeric($value) && !$this->checkRange($value) ||
			!$this->checkPattern($value)
		) return false;

		return true;
	}

}