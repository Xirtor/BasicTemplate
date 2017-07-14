<?php
/**
* @package Xirtor Database
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Db;

use \pdo;

/**
* QueryResult
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class QueryResult{

	public $stmt;
	public $classModel;

	public function __construct($stmt, $classModel){
		$this->stmt = $stmt;
		$this->classModel = $classModel;
	}

	public function statement(){
		return $this->stmt;
	}

	public function rowCount(){
		if (!$this->stmt) return false;
		return $this->stmt->rowCount();
	}

	public function array(){
		return $this->stmt ? $this->stmt->fetch(pdo::FETCH_ASSOC) : null;
	}

	public function arrays(){
		return $this->stmt ? $this->stmt->fetch(pdo::FETCH_ASSOC) : null;
	}

	public function object(){
		$record = $this->array();
		return $record ? new $this->classModel($record) : null;
	}

	public function objects(){
		$records = $this->arrays();
		$objects = [];
		if ($records) foreach ($records as $record) {
			$objects[] = new $this->classModel($record);
		}
		return $objects;
	}

}