<?php
/**
* @package Xirtor
* @link http://github.com/Xirtor/
* @copyright Copyright (c) Xirtor
*/
namespace Xirtor;

use Xirtor\Exception;

/**
* Simple Logger
* @since 0.1 Beta
* @author Egor Vasyakin <egor.vasyakin@itevas.ru>
*/

class Logger{

	/**
	* @static string code which converts the message to a writing format
	*/
	const writingFormat = 'return date("Y-m-d H:i:s")."\t$message\n";';

	/**
	* @static string regular expression for exploding data to buffer
	* simple example 
	* 		// get lines into a log
	* 		const explodingRegExp = '/(.*)\n/';
	* advanced example
	*		// get dates and messages into a log
	* 		const explodingRegExp = '/(?<date>.*)\t(?<message>.*)\n/';
	*/
	const explodingRegExp = '/(.*)\n/';

	public $filename;
	public $last;
	public $buffer;
	protected $_buffering = false;

	public function __construct(string $filename){
		$dir = substr($filename, 0, strrpos($filename, '/'));
		if (!strlen($dir)) $dir = dirname($_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF']);
		if (!is_readable($dir)) throw new Exception('Directory ('.$dir.') for log ('.$filename.') does not exists');
		$this->filename = $filename;
	}

	public function write($message){
		$this->last = eval(static::writingFormat);
		file_put_contents($this->filename, $this->last, FILE_APPEND);
		if ($this->_buffering === true) {
			$this->buffer[] = $this->last;
		}
	}

	public function buffering(){
		$this->_buffering = true;
	}

	public function isBuffering(){
		return $this->_buffering;
	}

	public function dropBuffering(){
		$this->_buffering = false;
	}

	public function read(){
		return file_get_contents($this->filename);
	}

	public function readToBuffer(){
		$data = $this->read();
		$match = preg_match_all(static::explodingRegExp, $data, $matches);
		if ($match) {
			array_shift($matches);
			$this->buffer = $matches;
		} else {
			$this->buffer = [];
		}
	}

}