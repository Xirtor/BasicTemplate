<?php

/**
* Template for displaying page
* @param object(User) user
*/

if (!isset($user)) $user = (object) ['name' => '', 'email' => '', 'password' => ''];

$this->render('header.php', ['title' => 'show user ' . $user->name]);

?>

<main class="page single-user">
	
	<div class="edit"><a href="<?=$this->app->dir?>users/<?=$user->id?>/edit">Edit profile</a></div>
	
	<h1><?=$user->name?></h1>

	<div class="content">
		<p><?=$user->email?></p>
	</div>

</main>

<?php
$this->render('footer.php');
?>