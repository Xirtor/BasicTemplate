<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Orm;

use Xirtor\Orm\QueryBuilder;

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

	public function getPublic(){
		return static::getDb()->getObjectVals($this);
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

	public function insert(){
		$row = $this->getPublic();
		$this->_noSet($row);
		$columns = array_keys($row);
		return static::getDb()->insert(static::tableName(), $columns, $row);
	}

	public function update(){
		$row = $this->getPublic();
		$this->_noSet($row);
		$columns = array_keys($row);
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

	public static function findBySql($sql){
		return static::getDb()->query($sql);
	}

}