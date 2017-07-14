<?php
/**
* @package Xirtor Database
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Db;

use pdo;
use PDOException;
use Xirtor\Exception;

/**
* Database connection
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Connection{

	public $driverName = '';
	public $host = '';
	public $dbname = '';
	public $username = '';
	public $password = '';
	public $options = [];
	public $charset = 'utf8';
	public $pdo;

	public function __construct(array $config = null){
		if ($config) foreach ($config as $key => $value) {
			if (isset($this->$key)) $this->$key = $value;
		}
	}

	public function open(){
		try {
			$dsn = "$this->driverName:host=$this->host;dbname=$this->dbname";
			$this->pdo = new pdo($dsn, $this->username, $this->password, $this->options);
			$this->query('SET NAMES ' . $this->charset);
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


	// transactions



	// quotes

	public function quote($value){
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

	public function quoteField($value){
		return "`$value`";
	}

	public function quoteTable($value){
		return "`$value`";
	}


	// base query
	public function query($sql){
		// echo "$sql <br>";
		return $this->pdo->query($sql);
	}

	public function prepare($sql){
		return $this->pdo->prepare($sql);
	}

	public function execute($stmt, array $params = null){
		if (!$stmt->execute($params)) {
			return $stmt;
		}
		return false;
	}




	// query operations
	public function insert($tbl, $keys, $values){
		$fields = [];
		$vals = [];
		foreach ($keys as $key) {
			$fields[] = $this->quoteField($key);
			$vals[] = $this->quote($values[$key]);
		}
		$sql = 'INSERT INTO ' . $this->quoteTable($tbl) . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $vals) . ')';
		// echo $sql;
		return $this->query($sql);
	}

	public function batchInsert($tbl, $keys, $rows){
		$fields = [];
		foreach ($keys as $key) {
			$fields[] = $this->quoteField($key);
		}
		$records = [];
		foreach ($rows as &$row) {
			$record = [];
			foreach ($keys as $key) {
				$record[] = $this->quote($row[$key]);
			}
			$records[] = '(' . implode(', ', $record) . ')';
		}
		$sql = 'INSERT INTO ' . $this->quoteTable($tbl) . ' (' . implode(', ', $fields) . ') VALUES ' . implode(', ', $records);
		// echo $sql;
		return $this->query($sql);
	}

	public function update($tbl, $keys, $values, $whereName, $whereValue){
		$update = '';
		$i = 0;
		foreach ($keys as $key) {
			if ($i > 0) {
				$update .= ', ';
			}
			$update .= $this->quoteField($key) . ' = ' . $this->quote($values[$key]);
			$i++;
		}
		$sql = 'UPDATE ' . $this->quoteTable($tbl) . ' SET ' . $update . ' WHERE ' . $this->quoteField($whereName) . ' = ' . $this->quote($whereValue);
		// echo $sql;
		return $this->query($sql);
	}

	public function delete($tbl, $whereName, $whereValue){
		$sql = 'DELETE FROM ' . $this->quoteTable($tbl) . ' WHERE ' . $this->quoteField($whereName) . ' = ' . $this->quote($whereValue);
		// echo $sql;
		return $this->query($sql);
	}


}