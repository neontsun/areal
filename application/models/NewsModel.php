<?php 

namespace application\models;

use application\core\Model;

class NewsModel extends Model {

	/* Получение всех новостей */
	public function getAllNews() {

		$returnedRequestFields = [
			'row_id',
			'title',
			'created_at',
			'description',
			'image_path'
		];

		$sqlQuery = "SELECT `row_id`, `title`, `created_at`, `description`, `image_path`
							   FROM  `news`";

		return $this->db->getQuery($sqlQuery, $returnedRequestFields, []);

	}
	
	/* Получение всех новостей по id*/
	public function getNewsById($row_id) {
		
		$returnedRequestFields = [
			'title',
			'description',
			'image_path'
		];
		
		$sqlQuery = "SELECT `title`, `description`, `image_path`
							   FROM  `news`
								 WHERE `row_id` = ?";
		
		$bindParams[] = [$row_id, "i"];
		
		return $this->db->getQuery($sqlQuery, $returnedRequestFields, $bindParams);
		
	}
	
	/* Добавление новости */
	public function insertNews($data) {
		
		$sqlQuery = "INSERT INTO `news` (`title`, `created_at`, `description`, `image_path`) 
								 VALUES (?, ?, ?, ?)";
		
		$bindParams[] = [$data['title'], "s"];
		$bindParams[] = [$data['created_at'], "s"];
		$bindParams[] = [$data['description'], "s"];
		$bindParams[] = [$data['image_path'], "s"];
		
		$this->db->postQuery($sqlQuery, $bindParams);
		
	}
	
	/* Обновление новости */
	public function updateNews($data, $row_id) {
		
		$sqlQuery = "UPDATE `news` SET ";
		
		foreach ($data as $key => $value) {
			
			$sqlQuery .= "`$key` = ?, ";
			$bindParams[] = [$value, "s"];
			
		}
		
		$sqlQuery = substr($sqlQuery, 0, -2) . ' ';
		$sqlQuery .= "WHERE `row_id` = ?";
		
		$bindParams[] = [$row_id, "i"];
		
		$this->db->postQuery($sqlQuery, $bindParams);
		
	}
	
	/* Обновление новости */
	public function deleteNews($row_id) {
		
		$sqlQuery = "DELETE FROM `news` WHERE `row_id` = ?";
	
		$bindParams[] = [$row_id, "i"];
		
		$this->db->postQuery($sqlQuery, $bindParams);
		
	}
	
}
