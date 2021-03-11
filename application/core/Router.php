<?php

namespace application\core;

class Router {
	
	protected $routes = [];
	protected $params = [];

	public function __construct() {

		$routesArray = require_once 'application/config/routes.php';
		
		foreach ($routesArray as $path => $setting) {
			$this->fillRoutesArray($path, $setting);
		}

	}
	
	private function fillRoutesArray($path, $setting) {

		$path = '#^' . $path . '$#';
		$this->routes[$path] = $setting;

	}

	private function match() {
		
		$url = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/');
		
		foreach ($this->routes as $path => $setting) {
			
			if (preg_match($path, $url, $matches)) {
				$this->params = $setting;
				return true;
			}

		}

		return false;

	}

	public function run() {

		if ($this->match()) {
			
			$controllerName = ucfirst($this->params["controller"]);
			$controllerPath = 'application\controllers\\' . $controllerName . 'Controller';

			if (class_exists($controllerPath)) {

				$actionName = $this->params["action"] . 'Action';

				if (method_exists($controllerPath, $actionName)) {
					
					$controller = new $controllerPath($this->params);
					$controller->$actionName();

				}
				else throw new Exception("Метод не найден");

			}
			else throw new Exception("Класс не найден");

		}
		else {
			
			header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
			require 'application/views/errors/404.php';

		}

	}

}
