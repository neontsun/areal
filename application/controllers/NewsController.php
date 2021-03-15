<?php

namespace application\controllers;

use application\core\Controller;
use application\models\NewsModel;
use DateTime;

class NewsController extends Controller {
	
	public function indexAction() {
		
		$newsModel = new NewsModel();
		
		$newsData = [];
		$limitPerPage = 5;
		$page = 1;
		
		if ($_GET) {
			
			$filter = 'сначала новые';
			
			if (isset($_GET['filter'])) {
				
				$filter = $_GET['filter'];
				
			}
			
			if (isset($_GET['page'])) {
				
				$page = $_GET['page'];
				
			}
			
			$newsData = $newsModel->getAllNews($limitPerPage, $filter, $page);

		}
		else {
			
			$newsData = $newsModel->getAllNews($limitPerPage);
			
		}
		
		$paginate = $newsModel->paginate($limitPerPage);
		
		foreach ($newsData as &$item) {
			
			$item['created_at'] = $this->getHumanDate($item['created_at']);
			
		}
		
		$this->view->render("Новости", [
			'news' => $newsData, 
			'paginate' => $paginate, 
			'page' => $page
		]);
		
	}
	
	public function addAction() {
		
		if ($_POST) {
			
			if (isset($_FILES['file'])) {
				
				$root = realpath(__DIR__ . '/../..');
				$path = '/public/img/news-img/';
				$fileName = $_FILES['file']['name'];
				$fileTmp = $_FILES['file']['tmp_name'];
				$filePath = $path . $fileName;
				
				move_uploaded_file($fileTmp, $root . $filePath);
				
				$_POST['created_at'] = date('Y-m-d H:i:s');
				$_POST['image_path'] = $filePath;
				
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
		
		if ($_POST) {
			
			if ($_POST['action'] == 'Редактировать') {
				
				if ($_FILES['file']['name']) {
				
					$root = realpath(__DIR__ . '/../..');
					$path = '/public/img/news-img/';
					$fileName = $_FILES['file']['name'];
					$fileTmp = $_FILES['file']['tmp_name'];
					$filePath = $path . $fileName;
					
					move_uploaded_file($fileTmp, $root . $filePath);
					
					$_POST['updated_at'] = date('Y-m-d H:i:s');
					$_POST['image_path'] = $filePath;
					
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
			elseif ($_POST["action"] == 'Удалить') {
				
				$newsModel->deleteNews($row_id);
				header("Location: /news");
				
			}
			
		}
		else {
			
			$newsData = $newsModel->getNewsById($row_id)[0];
			
			$newsData['real_path'] = realpath(
				__DIR__ . '/../..' . $newsData['image_path']
			);
			$tmp = explode('/', $newsData['image_path']);
			$newsData['image_name'] = end($tmp);
			
			$this->view->render("Редактировать новость", $newsData);
			
		}

	}
	
	private function getHumanDate($date) {
		
		$dt = date('d-m-Y', strtotime(str_replace('-','/', $date)));
		$dt = explode('-', $dt);
		$mon = "";

		switch ($dt[1]) {

			case 1: $mon = 'Января'; break;
			case 2: $mon = 'Февраля'; break;
			case 3: $mon = 'Марта'; break;
			case 4: $mon = 'Апреля'; break;
			case 5: $mon = 'Мая'; break;
			case 6: $mon = 'Июня'; break;
			case 7: $mon = 'Июля'; break;
			case 8: $mon = 'Августа'; break;
			case 9: $mon = 'Сентября'; break;
			case 10: $mon = 'Октября'; break;
			case 11: $mon = 'Ноября'; break;
			case 12: $mon = 'Декабря'; break;
			
		}

		return $dt[0] . " " . $mon . " " . $dt[2];
		
	}
	
}
