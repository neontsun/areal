<?php

namespace application\controllers;

use application\core\Controller;
use application\models\NewsModel;
use DateTime;

class NewsController extends Controller {
	
	public function indexAction() {
		
		$newsModel = new NewsModel();
		$news = [];
		
		if ($_GET) {
			
			if (isset($_GET['filter'])) {
				
				$news = $newsModel->getAllNews($_GET['filter']);
				
			}
			
		}
		else {
			
			$news = $newsModel->getAllNews();
			
		}
		
		$this->view->render("Новости", $news);

	}
	
	public function addAction() {
		
		if ($_POST) {
			
			if (isset($_FILES['file'])) {
				
				$root = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');
				$path = '/public/img/news-img/';
				$fileName = $_FILES['file']['name'];
				$fileTmp = $_FILES['file']['tmp_name'];
				$file = $path . $fileName;
				
				move_uploaded_file($fileTmp, $root . $file);
				
				$_POST['created_at'] = date('Y-m-d H:i:s');
				$_POST['image_path'] = $file;
				
				$newsModel = new NewsModel();
				$newsModel->insertNews($_POST);
				
				header("Location: /news");
				
			}
			
		}
		else
			$this->view->render("Добавить новость", []);

	}
	
	public function editAction() {
		
		$newsModel = new NewsModel();
		$row_id = $this->route['id'];
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			if ($_POST['action'] == 'Добавить') {
				
				if ($_FILES['file']['name']) {
				
					$root = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..');
					$path = '/public/img/news-img/';
					$fileName = $_FILES['file']['name'];
					$fileTmp = $_FILES['file']['tmp_name'];
					$file = $path . $fileName;
					
					move_uploaded_file($fileTmp, $root . $file);
					
					$_POST['updated_at'] = date('Y-m-d H:i:s');
					$_POST['image_path'] = $file;
					
					unset($_POST['action']);
					
					$newsModel->updateNews($_POST, $row_id);
					
					header("Location: /news");
					
				}
				else {
					
					$_POST['updated_at'] = date('Y-m-d H:i:s');
					
					unset($_POST['action']);
					
					$newsModel->updateNews($_POST, $row_id);
					
					header("Location: /news");
					
				}
				
			}
			else if ($_POST["action"] == 'Удалить') {
				
				unset($_POST['action']);
				
				$newsModel->deleteNews($row_id);
				
				header("Location: /news");
				
			}
			
		}
		else {
			
			$newsById = $newsModel->getNewsById($row_id)[0];
			
			$newsById['real_path'] = realpath(__DIR__ . '/' . '..' . '/' . '..' . $newsById['image_path']);
			$tmp = explode('/', $newsById['image_path']);
			$newsById['image_name'] = end($tmp);
			
			$this->view->render("Редактировать новость", $newsById);
			
		}

	}
	
}
