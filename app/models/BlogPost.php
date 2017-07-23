<?php

use Xirtor\Web\Model;

class BlogPost extends Model{

	public static $tableName = 'blog_posts';

	public $id;
	public $name;
	public $content;
	public $parent_id;
	public $author_id;

}