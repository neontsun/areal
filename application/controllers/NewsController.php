<?php

namespace application\controllers;

use application\core\Controller;
use application\models\NewsModel;

class NewsController extends Controller {
	
	public function indexAction() {
		
		$newsModel = new NewsModel();
		$news = $newsModel->getAllNews();
		
		$this->view->render("Новости", $news);

	}
	
	public function addAction() {
		
		if ($_POST) {
			header("Location: /news");
		}
		else 
			$this->view->render("Добавить новость", []);

	}
	
	public function editAction() {
		
		if ($_POST)  {
			//удаление
			//редирект на главную
		}
		else {
			$id = $this->route['id'];
			$this->view->render("Редактировать новость", []);
		}
		
	}
	
	private function deleteAction() {
		
	}
	
}

