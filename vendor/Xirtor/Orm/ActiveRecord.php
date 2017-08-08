<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Orm;

use Xirtor\Orm\QueryBuilder;
use Xirtor\Exception;

/**
* Active Record ORM
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class ActiveRecord{

	public static $primaryKey = 'id';

	protected $_private = [];

	protected static $_noSet;

	public function __construct(array $params = null){
		if ($params) foreach ($params as $name => $value) $this->$name = $value;
	}

	public function __set($name, $value){
		$this->_private[$name] = $value;
	}

	public function __get($name){
		return isset($this->_private[$name]) ? $this->_private[$name] : null;
	}

	public function __isset($name){
		return isset($this->_private[$name]);
	}

	public function __unset($name){
		unset($this->_private[$name]);
	}

	public function getPublic($columns = null){
		$values = static::getDb()->getObjectVals($this);
		if ($columns) {
			if (!is_array($columns)) throw new Exception('Argument 1 columns must be array in ' . get_called_class() . ' object');
			$real = [];
			$recordColumns = $this->getColumns();
			foreach ($columns as $column) {
				if (!in_array($column, $recordColumns)) throw new Exception('Variable ' . $column . ' not found in ' . get_called_class() . ' object');
				$real[$column] = $values[$column];
			}
			$values = &$real;

		}
		return $values;
	}

	public function getColumns(){
		return array_keys($this->getPublic());
	}

	public function getPrivate(){
		return $this->_private;
	}

	protected function _noSet(&$values){
		if (static::$_noSet) foreach (static::$_noSet as $column) {
			unset($values[$column]);
		}
		unset($values[static::$primaryKey]);
	}

	public function insert($columns = null){
		$row = $this->getPublic($columns);
		$this->_noSet($row);
		if (!$columns) $columns = array_keys($row);
		$result = static::getDb()->insert(static::tableName(), $columns, $row);
		if ($result) $this->id = static::getDb()->lastInsertId(static::tableName());
		return $result;
	}

	public function update($columns = null){
		$row = $this->getPublic($columns);
		$this->_noSet($row);
		if (!$columns) $columns = array_keys($row);
		$byColumn = static::$primaryKey;
		$byValue = $this->$byColumn;
		return static::getDb()->update(static::tableName(), $byColumn, $byValue, $columns, $row);
	}

	public function delete(){
		$byColumn = static::$primaryKey;
		$byValue = $this->$byColumn;
		return static::getDb()->delete(static::tableName(), $byColumn, $byValue);
	}

	public static function find(){
		return new QueryBuilder(get_called_class());
	}

	public static function findById($id){
		return (new QueryBuilder(get_called_class()))->where('=', 'id', $id)->one();
	}

	public static function findBySql($sql){
		return static::getDb()->query($sql);
	}

}