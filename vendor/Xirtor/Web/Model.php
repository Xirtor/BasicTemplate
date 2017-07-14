<?php
/**
* @package Xirtor MVC
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor\Web;

use Xirtor;
use Xirtor\Db\ActiveRecord;

/**
* Model class
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Model extends ActiveRecord{

	public static $tableName;
	public static $db;	

	public static function tableName(){
		if (isset(static::$tableName)) return static::$tableName;
		$names = explode('\\', get_called_class());
		return strtolower(array_pop($names)) . 's';
	}

	public static function getDb(){
		return self::$db;
	}

	public function update($keys = null, $whereKey = null, $whereValue = null){
		$this->update_time = date('Y-m-d H:i:s');
		return parent::update($keys, $whereKey, $whereValue);
	}

}