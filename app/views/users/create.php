<?php

/**
* Template for displaying page
* @param string error
* @param object(User) user
*/

if (!isset($user)) $user = (object) ['name' => '', 'email' => '', 'password' => ''];

$this->render('header.php', ['title' => 'create user']);

?>

<main class="page create-user">
	
	<h1>Create user</h1>

	<? if (isset($error)): ?>

	<p class="error"><?=$error?></p>

	<? endif; ?>

	<form method="POST">
		<input type="text" name="name" maxlength="30" placeholder="name" value="<?=$user->name?>">
		<input type="text" name="email" maxlength="30" placeholder="email" value="<?=$user->email?>">
		<input type="password" name="password" maxlength="30" placeholder="password" value="<?=$user->password?>">
		<button type="submit">Create</button>
	</form>

</main>

<?php
$this->render('footer.php');
?>