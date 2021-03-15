<?php

namespace application\core;

class View {

	private $viewPath;

	public function __construct($route) {

		$this->viewPath = $route['controller'] . '/' . $route["action"];

	}

	public function render($title, $data = []) {
		
		$path = 'application/views/' . $this->viewPath . '.php';

		if (file_exists($path)) {
			
			ob_start();
			require $path;
			$content = ob_get_clean();
			require_once 'application/views/layouts/main.php';

		}
		else throw new Exception("Вид не найден");

	}

}
