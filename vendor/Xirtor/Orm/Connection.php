<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Orm;

use \pdo;
use \PDOException;
use Xirtor\Object;
use Xirtor\Exception;

/**
* Database connection
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class Connection extends Object{

	public $driver_name;
	public $host;
	public $dbname;
	public $username;
	public $password;
	public $options = [];
	public $charset = 'utf8';

	public $pdo;

	public function open(){
		try {
			$dsn = "$this->driver_name:host=$this->host";
			if ($this->dbname) $dsn .= ";dbname=$this->dbname";
			$this->pdo = new pdo($dsn, $this->username, $this->password, $this->options);
			$this->pdo->query('SET NAMES ' . $this->charset);
		} catch (PDOException $e) {
			throw new Exception('database connection error: ' . $e->getMessage());
		}
	}

	public function isOpen(){
		return $this->pdo !== null;
	}

	public function close(){
		$this->pdo = null;
	}




	public function quoteValue($value){
		if (is_string($value)) {
			$value = trim($value);
			if (($value = $this->pdo->quote($value)) !== false) {
				return $value;
			} else {
				return "'" . addcslashes(str_replace("'", "''", $value)) . "'";
			}
		} else if (is_numeric($value)) {
			return $value;
		} else if (is_bool($value)) {
			return (int) $value;
		} else if (empty($value)) {
			return 'NULL';
		}
	}

	public function quoteColumn($column){
		return '`' . preg_replace('/ *, */', '`$0`', $column) . '`';
	}

	public function quoteTable($name){
		return '`' . str_replace('.', '`.`', $name) . '`';
	}


	public function getObjectVals($object){
		return get_object_vars($object);
	}



	public function query($sql){
		echo '<b>database query:</b> ' . $sql . '<br>';
		return $this->pdo->query($sql);
	}

	public function prepare($sql){
		return $this->pdo->prepare($sql);
	}

	public function execute($stmt, array $params = null){
		$stmt->execute($params);
		return $stmt;
	}




	public function lastInsertId($tbl = null){
		return $this->pdo->lastInsertId($tbl);
	}





	public function insert($tbl, array $columns, &$row){
		$tbl = $this->quoteTable($tbl);
		$record = [];
		foreach ($columns as $i => $column) {
			// $value = $row[$column];
			// if (empty($value)) unset($columns[$i]);
			// else $record[] = $this->quoteValue($value);
			$record[] = $this->quoteValue($row[$column]);
		}
		$columns = $this->quoteColumn(implode(', ', $columns));
		return $this->query('INSERT INTO ' . $tbl . ' (' . $columns . ') VALUES (' . implode(', ', $record) . ')');
	}

	public function batchInsert($tbl, array $columns, &$rows){
		$tbl = $this->quoteTable($tbl);
		$records = [];
		foreach ($rows as &$row) {
			$record = [];
			foreach ($columns as &$column) {
				$record[] = $row[$column];
			}
			$records[] = '(' . implode(', ', $record) . ')';
		}
		$columns = $this->quoteColumn(implode(', ', $columns));
		return $this->query('INSERT INTO ' . $tbl . ' (' . $columns . ') VALUES ' . implode(', ', $records));
	}

	public function update($tbl, $byColumn, $byValue, array $columns, &$row){
		$tbl = $this->quoteTable($tbl);
		$byColumn = $this->quoteColumn($byColumn);
		$byValue = $this->quoteValue($byValue);
		$record = [];
		foreach ($columns as &$column) {
			$value = $this->quoteValue($row[$column]);
			$column = $this->quoteColumn($column);
			$record[] = $column . ' = ' . $value;
		}
		return $this->query('UPDATE ' . $tbl . ' SET ' . implode(', ', $record) . ' WHERE ' . $byColumn . ' = ' . $byValue);
	}

	public function delete($tbl, $byColumn, $byValue){
		$tbl = $this->quoteTable($tbl);
		$byColumn = $this->quoteColumn($byColumn);
		$byValue = $this->quoteValue($byValue);
		return $this->query('DELETE FROM ' . $tbl . ' WHERE ' . $byColumn . ' = ' . $byValue);
	}


}