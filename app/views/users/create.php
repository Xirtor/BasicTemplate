<?php

/**
* Template for displaying page
* @param string error
*/

$this->render('header.php', ['title' => 'create user']);

?>

<main class="page create-user">
	
	<h1>Create user</h1>

	<? if (isset($error)): ?>

	<p class="error"><?=$error?></p>

	<? endif; ?>

	<form method="POST">
		<input type="text" name="name" maxlength="30" placeholder="name">
		<input type="text" name="email" maxlength="30" placeholder="email">
		<input type="text" name="password" maxlength="30" placeholder="password">
		<button type="submit">Create</button>
	</form>

</main>

<?php
$this->render('footer.php');
?>