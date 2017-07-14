<?php

// index action

return function (){

	$title = 'Home page';
	$content = 'Displaying home page';
	
	// вывод представления
	$this->view->render('page.php', ['title' => $title, 'content' => $content]);

};