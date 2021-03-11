<?php

use application\core\Router;
require_once 'application/functions/dev.php';

try {
	
	spl_autoload_register(function ($class) {

		$classPath = str_replace('\\', '/', $class . '.php');

		if (file_exists($classPath)) {
			require __DIR__ . "\\" . $classPath;
		}
		else throw new Exception("Класс не найден");

	});

	session_start();

	$router = new Router();
	$router->run();

} 
catch (Exception $e) {
	
	var_dump($e->getMessage());

}
