<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Orm;

use \pdo;

/**
* Query Result ORM
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class QueryResult{

	public $classModel = 'ActiveRecord';
	public $stmt;

	public function __construct($stmt, $classModel = null){
		$this->stmt = $stmt;
		if ($classModel) $this->classModel = &$classModel;
	}

	public function stmt(){
		return $this->stmt;
	}

	public function rowCount(){
		return $this->stmt ? $this->stmt->rowCount() : false;
	}

	public function array(){
		return $this->stmt ? $this->stmt->fetch(pdo::FETCH_ASSOC) : false;
	}

	public function arrays(){
		return $this->stmt ? $this->stmt->fetchAll(pdo::FETCH_ASSOC) : false;
	}

	public function object(){
		$record = $this->array();
		return $record ? new $this->classModel($record) : null;
	}

	public function objects(){
		$objects = [];
		$count = $this->rowCount();
		for ($i = 0; $i < $count; $i++) {
			$record = $this->array();
			$objects[] = $record ? $this->classModel($record) : null;
		}
		return $objects;
	}

}