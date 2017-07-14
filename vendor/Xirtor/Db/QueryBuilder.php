<?php
/**
* @package Xirtor Database
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Db;

use Xirtor\Db\QueryResult;
use Xirtor\Exception;

/**
* QueryBuilder
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class QueryBuilder{

	public $classModel;

	public $select = '*';
	public $where;
	public $offset;
	public $limit;
	public $orderBy;
	public $desc;

	public function __construct($classModel){
		$this->classModel = $classModel;
	}

	public function select($select){
		if (is_array($select)) $select = implode(', ', $select);
		$this->select = $select;
		return $this;
	}

	public function quoteWhere($exp){
		if (!preg_match('/^([a-zA-Z0-9-_]*) (=|<|<=|>|>=) (.*)$/', $exp, $matches)) {
			throw new Exception('QueryBuilder fatal error! Incorrectly argument 1 for where');
		}
		$matches[0] = $this->classModel::getDb()->quoteField($matches[1]);
		$matches[1] = $matches[2];
		$matches[2] = $this->classModel::getDb()->quote($matches[3]);
		unset($matches[3]);
		return implode(' ', $matches);
		
		// 
		$parts = explode(' ', $exp);
		if (count($parts) !== 3) {
			throw new Exception('QueryBuilder fatal error! Incorrectly argument 1 for where');
		}
		$parts[0] = $this->classModel::getDb()->quoteField($parts[0]);
		$parts[2] = $this->classModel::getDb()->quote($parts[2]);
		return implode(' ', $parts);
	}

	public function where($exp){
		$this->where = 'WHERE ' . $this->quoteWhere($exp);
		return $this;
	}

	public function andWhere($exp){
		$this->where .= ' AND ' . $this->quoteWhere($exp);
		return $this;
	}

	public function orWhere($exp){
		$this->where .= ' OR ' . $this->quoteWhere($exp);
		return $this;
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
		$this->orderBy = $orderBy;
		return $this;
	}

	public function sortDesc(){
		$this->desc = true;
		return $this;
	}

	public function get(){
		$where = $this->where;
		$limit = '';
		if ($this->limit) {
			$limit = 'LIMIT ';
			if ($this->offset) {
				$limit .= $this->offset . ', ';
			}
			$limit .= $this->limit;
		}
		$order = $this->orderBy ? ('ORDER BY ' . $this->orderBy) : '';
		$desc = $this->desc === true ? 'DESC' : '';

		$sql = 'SELECT ' . $this->select . ' FROM ' . $this->classModel::getDb()->quoteTable($this->classModel::tableName()) . " $where $limit $order $desc";
		return new QueryResult($this->classModel::getDb()->query($sql), $this->classModel);
	}

	public function one(){
		$this->limit = 1;
		return $this->get();
	}

}