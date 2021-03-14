<?php 

namespace application\models;

use application\core\Model;

class NewsModel extends Model {

	/* Получение всех новостей */
	public function getAllNews($limit, $filter = 'сначала новые', $page = 1) {
		
		$returnedRequestFields = [
			'row_id',
			'title',
			'created_at',
			'description',
			'image_path'
		];
		
		$filterMode = '';
		
		$sqlQuery = "SELECT `row_id`, `title`, `created_at`, `description`, `image_path`
							   FROM  `news`
								 ORDER BY `created_at` ";
		
		switch ($filter) {
			case 'сначала новые':	$filterMode = 'DESC'; break;
			case 'сначала старые':	$filterMode = 'ASC'; break;
		}
		
		$sqlQuery .= $filterMode;
		
		if ($page == 1) {
			$sqlQuery .= " LIMIT $limit";
		}
		elseif ($page == 2) {
			$sqlQuery .= " LIMIT $limit OFFSET " . $limit;
		}
		else {
			$sqlQuery .= " LIMIT $limit OFFSET " . (($limit * $page) - $limit);
		}
		
		return $this->db->getQuery($sqlQuery, $returnedRequestFields, []);

	}
	
	// Получение страниц
	public function paginate($limit = 1) {
		
		$returnedRequestFields = [
			'count'
		];
		
		$filterMode = '';
		
		$sqlQuery = "SELECT COUNT(`row_id`)
							   FROM  `news`";
		
		
		
		$rowCount =  $this->db->getQuery($sqlQuery, $returnedRequestFields, []);
		$pageCount = ceil($rowCount[0]['count'] / $limit);
		
		return [
			'page_count' => $pageCount,
			'first_page' => 1,
			'last_page' => $pageCount,
		];
		
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
