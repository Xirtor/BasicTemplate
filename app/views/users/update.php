<?php

/**
* Template for displaying page
* @param object(User) user
* @param string error
*/

if (!isset($user)) $user = (object) ['name' => '', 'email' => '', 'password' => '', 'password_new' => ''];

$this->render('header.php', ['title' => 'update user "' . $user->name . '"']);

?>

<main class="page update-user">
	
	<h1>Update user id<?=$user->id?></h1>

	<div class="delete-link">
		<a href="<?=$this->app->dir?>users/<?=$user->id?>/delete">delete user</a>
	</div>

	<? if (isset($error)): ?>

	<p class="error"><?=$error?></p>

	<? endif; ?>

	<? if (isset($success)): ?>

	<p class="success"><?=$success?></p>

	<? endif; ?>

	<h2>Update profile data</h2>

	<form method="POST">
		<input type="text" name="name" maxlength="30" placeholder="name" value="<?=$user->name?>">
		<input type="text" name="email" maxlength="30" placeholder="email" value="<?=$user->email?>">
		<button type="submit">Save</button>
	</form>

	<h2>Update password</h2>

	<form method="POST">
		<input type="password" name="password" maxlength="30" placeholder="password" value="<?=$user->password?>">
		<input type="password" name="password_new" maxlength="30" placeholder="new password" value="<?=$user->password_new?>">
		<button type="submit">Update password</button>
	</form>

</main>

<?php
$this->render('footer.php');
?>