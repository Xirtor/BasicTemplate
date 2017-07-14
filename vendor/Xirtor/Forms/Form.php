<?php
/**
* @package Xirtor Forms
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Forms;

use Xirtor\Forms\Field;

/**
* Form
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Form{

	public $fields = [];
	public $fieldsMap = [];
	public $values = [];
	public $equals = [];

	public $errors = [];

	// error patterns
	public static $patterns = [
		'equalFailed' => '\'Values of fields "\' . implode(\'", "\', $names) . \'" not equal\''
	];

	public function createField($type, $name){
		return $this->addField(new Field($type, $name));
	}

	public function addField($field){
		$this->fields[] = &$field;
		$this->fieldsMap[$field->name] = &$field;
		return $field;
	}

	public function field($name){
		return isset($this->fieldsMap[$name]) ? $this->fieldsMap[$name] : null;
	}

	public function equal(array $names){
		$this->equals[] = $names;
	}

	public function validate(array $values = null){
		if (!$values) $values = $this->values;
		else $this->values = $values;

		foreach ($this->fields as $field) {
			$value = isset($values[$field->name]) ? $values[$field->name] : null;
			if (!$field->validate($value)) {
				$this->errors[] = $field->error;
			}
		}

		foreach ($this->equals as $names) {
			$i = 0;
			foreach ($names as $name) {
				$value = $this->field($name)->value;
				if ($i > 0) {
					if ($value !== $last) {
						$this->errors[] = eval('return ' . static::$patterns['equalFailed'] . ';');
					}
				}
				$last = $value;
				$i++;
			}
		}

		return empty($this->errors);

	}

}