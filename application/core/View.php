<?php

namespace application\core;

class View {

	public $actionPath;
	public $route;

	public function __construct($route) {

		$this->route = $route;
		$this->actionPath = $route['controller'] . '/' . $route["action"];

	}

	public function render($title, $data = []) {
		
		$path = 'application/views/' . $this->actionPath . '.php';

		if (file_exists($path)) {
			
			ob_start();
			require $path;
			$content = ob_get_clean();

			require_once 'application/views/layouts/main.php';

		}
		else throw new Exception("Вид не найден");

	}

}
