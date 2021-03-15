<?php 

namespace application\models;

use application\core\Model;

class NewsModel extends Model {

	/* Получение всех новостей */
	public function getAllNews($limit, $filter = 'сначала новые', $page = 1) {
		
		$returnedFields = [
			'row_id',
			'title',
			'created_at',
			'description',
			'image_path'
		];
		
		$filterMode = '';
		
		switch ($filter) {
			case 'сначала новые':	$filterMode = 'DESC'; break;
			case 'сначала старые':	$filterMode = 'ASC'; break;
		}
		
		$query = "SELECT 
								`row_id`, 
								`title`, 
								`created_at`, 
								`description`, 
								`image_path`
							FROM 
								`news`
							ORDER BY 
								`created_at` $filterMode 
							LIMIT 
								$limit ";
		
		if ($page == 2) {
			
			$query .= "OFFSET $limit";
			
		}
		elseif ($page > 2) {
			
			$offset = ($limit * $page) - $limit;
			$query .= "OFFSET $offset";
			
		}
		
		return $this->db->getQuery($query, $returnedFields, []);

	}
	
	// Получение страниц
	public function paginate($limit = 1) {
		
		$returnedFields = [
			'count'
		];
		
		$filterMode = '';
		
		$query = "SELECT 
								COUNT(`row_id`)
							FROM 
								`news`";
		
		
		
		$rowCount =  $this->db->getQuery($query, $returnedFields, []);
		$pageCount = ceil($rowCount[0]['count'] / $limit);
		
		return [
			'page_count' => $pageCount,
			'first_page' => 1,
			'last_page' => $pageCount
		];
		
	}
	
	/* Получение всех новостей по id*/
	public function getNewsById($row_id) {
		
		$returnedFields = [
			'title',
			'description',
			'image_path'
		];
		
		$query = "SELECT 
								`title`, 
								`description`, 
								`image_path`
							FROM 
								`news`
							WHERE 
								`row_id` = ?";
		
		$prepareParams[] = [$row_id, "i"];
		
		return $this->db->getQuery($query, $returnedFields, $prepareParams);
		
	}
	
	/* Добавление новости */
	public function insertNews($data) {
		
		$query = "INSERT INTO `news` 
								(`title`, `created_at`, `description`, `image_path`) 
							VALUES 
								(?, ?, ?, ?)";
		
		$prepareParams[] = [$data['title'], "s"];
		$prepareParams[] = [$data['created_at'], "s"];
		$prepareParams[] = [$data['description'], "s"];
		$prepareParams[] = [$data['image_path'], "s"];
		
		$this->db->postQuery($query, $prepareParams);
		
	}
	
	/* Обновление новости */
	public function updateNews($data, $row_id) {
		
		$query = "UPDATE `news` SET ";
		
		foreach ($data as $key => $value) {
			
			$query .= "`$key` = ?, ";
			$prepareParams[] = [$value, "s"];
			
		}
		
		$query = substr($query, 0, -2) . ' ';
		$query .= "WHERE `row_id` = ?";
		$prepareParams[] = [$row_id, "i"];
		
		$this->db->postQuery($query, $prepareParams);
		
	}
	
	/* Удаление новости */
	public function deleteNews($row_id) {
		
		$query = "DELETE FROM 
								`news` 
							WHERE 
								`row_id` = ?";
	
		$prepareParams[] = [$row_id, "i"];
		
		$this->db->postQuery($query, $prepareParams);
		
	}
	
}
