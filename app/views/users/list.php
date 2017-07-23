<?php

/**
* Template for displaying page
* @param string page title
* @param array of objects(User) users
*/

$this->render('header.php', ['title' => $title]);

?>

<main class="page">
	
	<h1><?=$title?></h1>

	<div class="content">
	<? if (isset($users)): ?>

		<ul class="users">
		<? foreach ($users as $user): ?>

			<li>
				<a href="<?=$this->app->dir?>users/<?=$user->id?>">
					<h2><?=$user->name?></h2>
					<p><?=$user->email?></p>
				</a>
			</li>

		<? endforeach; ?>
		</ul>

	<? else: ?>

	<? endif; ?>
	</div>

</main>

<?php
$this->render('footer.php');
?>