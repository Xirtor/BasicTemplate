<?php

use Xirtor\Web\Model;

class User extends Model{

	public $id;
	public $name;
	public $email;
	public $hash;

	public function passwordToHash(){
		$this->hash = password_hash($this->password, PASSWORD_DEFAULT);
	}

	public function passwordVerify(){
		return password_verify($this->password, $this->hash);
	}

}