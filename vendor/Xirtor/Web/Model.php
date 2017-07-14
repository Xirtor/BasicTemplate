<?php
/**
* @package Xirtor
* @link https://github.com/xirtor
* @copyright Copyright (c) XirtorTeam
*/

namespace Xirtor\Web;

use Xirtor\Orm\ActiveRecord;

/**
* MVC Model
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
* @since 1.0
*/

class Model extends ActiveRecord{
	
	public static $tableName;
	public static $db;

	// не записывать при insert и update
	protected static $_noSet = ['create_time', 'update_time'];

	public $create_time;
	public $update_time;


	public static function tableName(){
		return isset(static::$tableName) ? static::$tableName : ( strtolower(get_called_class()) . 's' );
	}

	public static function getDb(){
		return static::$db;
	}

}