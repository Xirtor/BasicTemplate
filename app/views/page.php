<?php

/**
* Template for displaying page
* @param string page title
* @param string page content
*/

$this->render('header.php', ['title' => $title]);

?>

<main class="page">
	
	<h1><?=$title?></h1>

	<div class="content">
		<?=$content?>
	</div>

</main>

<?php
$this->render('footer.php');
?>