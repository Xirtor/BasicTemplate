<?php

/**
* Template for displaying header
* @param string page title
*/

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
	<link rel="stylesheet" type="text/css" href="<?=$this->app->dir?>assets/css/style.css">
</head>
<body>

<header class="page-header">
	<nav>
		<a href="<?=$this->app->dir?>">Home</a>
		<a href="<?=$this->app->dir?>users">Users</a>
		<a href="<?=$this->app->dir?>users/create">Create user</a>
	</nav>
</header>