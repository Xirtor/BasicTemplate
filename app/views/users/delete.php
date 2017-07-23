<?php

/**
* Template for displaying page
* @param object(User) user
* @param string error
*/

if (!isset($user)) $user = (object) ['name' => '', 'email' => '', 'password' => ''];

$this->render('header.php', ['title' => 'delete user "' . $user->name . '"']);

?>

<main class="page delete-user">
	
	<h1>Delete user id<?=$user->id?></h1>

	<? if (isset($error)): ?>

	<p class="error"><?=$error?></p>

	<? endif; ?>

	<? if (isset($success)): ?>

	<p class="success"><?=$success?></p>

	<? endif; ?>

</main>

<?php
$this->render('footer.php');
?>