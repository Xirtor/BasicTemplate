<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Orm;

use Xirtor\Orm\QueryResult;

/**
* Query Builder ORM
* @author Egor Vasyakin <egor.vasykin@itevas.ru>
* @since 1.0
*/

class QueryBuilder{

	public $classModel;

	public $select = '*';
	public $where;
	public $offset;
	public $limit;
	public $orderBy;
	public $orderDesc = false;
	public $groupBy;

	public function __construct($classModel){
		$this->classModel = &$classModel;
	}

	public function select($select){
		$this->select = $this->classModel::getDb()->quoteColumn(is_array($select) ? implode(', ', $select) : $select);
		return $this;
	}




	protected function _addWhere($where){
		$this->where .= $where;
		return $this;
	}

	public function where($cond, $column, $value){
		$column = $this->classModel::getDb()->quoteColumn($column);
		$value = $this->classModel::getDb()->quoteValue($value);
		return $this->_addWhere($column . ' ' . $cond . ' ' . $value);
	}

	public function and(){
		return $this->_addWhere(' AND ');
	}

	public function or(){
		return $this->_addWhere(' OR ');
	}

	public function openBracket(){
		return $this->_addWhere('(');
	}

	public function closeBracket(){
		return $this->_addWhere(')');
	}






	public function offset($offset){
		$this->offset = $offset;
		return $this;
	}

	public function limit($limit){
		$this->limit = $limit;
		return $this;
	}

	public function orderBy($orderBy){
		$this->orderBy = is_array($orderBy) ? implode(', ', $orderBy) : $orderBy;
		return $this;
	}

	public function orderDesc(){
		$this->orderDesc = true;
		return $this;
	}

	public function groupBy($groupBy){
		$this->groupBy = is_array($groupBy) ? implode(', ', $groupBy) : $groupBy;
		return $this;
	}


	public function get(){
		$tbl = $this->classModel::getDb()->quoteTable($this->classModel::tableName());
		$select = $this->select;
		$sql = 'SELECT ' . $select .' FROM ' . $tbl;
		if ($this->where) $sql .= ' WHERE ' . $this->where;
		if ($this->limit) $sql .= ' LIMIT ' . $this->limit;
		if ($this->offset) $sql .= ' OFFSET ' . $this->offset;
		if ($this->orderBy) $sql .= ' ORDER BY ' . $this->classModel::getDb()->quoteColumn($this->orderBy);
		if ($this->orderDesc) $sql .= ' DESC';
		if ($this->groupBy) $sql .= ' GROUP BY ' . $this->classModel::getDb()->quoteColumn($this->groupBy);

		$stmt = $this->classModel::getDb()->query($sql);
		return new QueryResult($stmt, $this->classModel);
	}

	public function one(){
		$this->limit = 1;
		return $this->get();
	}

}