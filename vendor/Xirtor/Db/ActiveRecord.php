<?php
/**
* @package Xirtor Database
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Db;

use Xirtor\Db\QueryBuilder;

/**
* ActiveRecord
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class ActiveRecord{

	public static function tableName(){
		// 
	}
	public static function getDb(){
		// 
	}

	public static $primaryKey = 'id';

	public function __construct(array $values = null){
		if ($values) $this->import($values);
	}

	public function import(array $values){
		foreach ($values as $name => $value) {
			$this->$name = $value;
		}
	}

	// record values
	protected $_values = [];

	public function __set($name, $value){
		if (is_string($name)) $this->_values[$name] = $value;
	}

	public function __get($name){
		return isset($this->_values[$name]) ? $this->_values[$name] : null;
	}

	public function __isset($name){
		return isset($this->_values[$name]);
	}

	public function __unset($name){
		unset($this->_values[$name]);
	}

	public function export($keys = null){
		if (!$keys) return $this->_values;
		$values = [];
		foreach ($keys as $key) {
			$values[$key] = $this->$key;
		}
		return $values;
	}



	public function getKeys(){
		return array_keys($this->_values);
	}


	// database operations

	public function insert($keys = null){
		$values = $this->export($keys);
		$keys = array_keys($values);
		return static::getDb()->insert(static::tableName(), $keys, $values);
	}

	public function update($keys = null, $whereKey = null, $whereValue = null){
		if (!$whereKey) $whereKey = static::$primaryKey;
		if (!$whereValue) $whereValue = $this->$whereKey;
		$values = $this->export($keys);
		$keys = array_keys($values);
		return static::getDb()->update(static::tableName(), $keys, $values, $whereKey, $whereValue);
	}

	public function delete($whereKey = null, $whereValue = null){
		if (!$whereKey) $whereKey = static::$primaryKey;
		if (!$whereValue) $whereValue = $this->$whereKey;
		return static::getDb()->delete(static::tableName(), $whereKey, $whereValue);
	}

	public static function find(){
		return new QueryBuilder(get_called_class());
	}

	public static function findBySql($sql){
		return static::getDb()->query($sql);
	}

	public static function findByPrimary($id){
		return static::find()->where(static::$primaryKey . ' = ' . $id)->one()->object();
	}

}