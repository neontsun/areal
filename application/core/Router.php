<?php

namespace application\core;

class Router {
	
	private $routes = [];
	private $params = [];

	public function __construct() {

		$routes = require_once 'application/config/routes.php';
		
		foreach ($routes as $path => $setting) {
			
			$changePath = preg_replace(
				'/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', 
				$path
			);
			$changePath = '#^' . $changePath . '$#';
			$this->routes[$changePath] = $setting;
			
		}

	}
	
	private function match() {
		
		$url = trim(
			parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), 
			'/'
		);
		
		foreach ($this->routes as $path => $setting) {
			
			if (preg_match($path, $url, $matches)) {
				
				foreach ($matches as $key => $match) {
					
					if (is_string($key)) {
						
						if (is_numeric($match)) {
							
							$match = (int) $match;
							
						}
						
						$setting[$key] = $match;
						
					}
					
				}
				
				$this->params = $setting;
				
				return true;
				
			}

		}

		return false;

	}

	public function run() {

		if ($this->match()) {
			
			$controllerName = ucfirst($this->params["controller"]) . 'Controller';
			$controllerPath = 'application\controllers\\' . $controllerName;

			if (class_exists($controllerPath)) {

				$actionName = $this->params["action"] . 'Action';

				if (method_exists($controllerPath, $actionName)) {
					
					$controller = new $controllerPath($this->params);
					$controller->$actionName();

				}
				else 
					throw new Exception("Метод не найден");

			}
			else 
				throw new Exception("Класс не найден");

		}
		else {
			
			header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
			require 'application/views/errors/404.php';

		}

	}

}
