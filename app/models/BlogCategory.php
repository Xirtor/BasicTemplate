<?php

use Xirtor\Web\Model;

class BlogCategory extends Model{

	public static $tableName = 'blog_categories';

	public $id;
	public $name;
	public $parent_id;
	public $author_id;

}