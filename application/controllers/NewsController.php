<?php

namespace application\controllers;

use application\core\Controller;
use application\models\RecipeModel;
use application\models\CommentModel;
use application\models\CategoryModel;
use application\models\ImageModel;

class NewsController extends Controller {
	
	public function indexAction() {

		$this->view->render("Новости", []);

	}

}

