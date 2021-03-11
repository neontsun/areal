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
		
		$this->view->render("Добавить новость", []);

	}

}

