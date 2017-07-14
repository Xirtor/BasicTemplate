<?php

// 404 action

return function (){
	header('HTTP/1.1 404 Not Found');
	echo '404. Not Found';
};