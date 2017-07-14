<?php

/**
* Template for displaying page
* @param object(User) user
*/

$this->render('header.php', ['title' => 'show user ' . $user->name]);

?>

<main class="page single-user">
	
	<h1><?=$user->name?></h1>

	<div class="content">
		<p><?=$user->email?></p>
	</div>

</main>

<?php
$this->render('footer.php');
?>