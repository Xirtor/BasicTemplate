<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Validation;

use Xirtor\Object;
use Xirtor\Validation\InputValidator;

/**
* Validator
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class Validator extends Object{
	
	public $encoding = 'utf-8';
	public $inputs = [];
	public $values = [];
	public $errors = [];

	public function init(){
		if (!empty($this->inputs)) foreach ($this->inputs as $name => $config) {
			$this->inputs[$name] = new InputValidator($config);
		}
	}

	public function validate(array $values){
		$this->values = $values;
		mb_internal_encoding($this->encoding);
		foreach ($this->inputs as $name => &$input) {
			$value = isset($values[$name]) ? $values[$name] : null;
			if (!$input->validate($value)) {
				$this->errors[] = $input->error;
				return false;
			}
		}
		return true;
	}

}