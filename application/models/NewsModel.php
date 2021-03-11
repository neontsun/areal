<?php 

namespace application\models;

use application\core\Model;

class NewsModel extends Model {

	/* Получение всех рецептов */
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
	
	public function getNewsById($row_id) {
		
		$returnedRequestFields = [
			'row_id',
			'title',
			'created_at',
			'description',
			'image_path'
		];
		
		$sqlQuery = "SELECT `row_id`, `title`, `created_at`, `description`, `image_path`
							   FROM  `news`
								 WHERE `row_id` = ?";
		
		$bindParams[$row_id] = "i";
		
		return $this->db->getQuery($sqlQuery, $returnedRequestFields, $bindParams);
		
	}

	// /* Получение рецепта в соответствии с параметрами запроса */
	// public function getRecipeByFilter($params, $orderField = "row_id", $orderMethod = "DESC") {
		
	// 	$returnedRequestFields = [
	// 		'row_id',
	// 		'title',
	// 		'description',
	// 		'like_count',
	// 		'link',
	// 		'date'
	// 	];
	// 	$bindParams = [];

	// 	$sqlQuery = "SELECT r.`row_id`, r.`title`, r.`description`, r.`like_count`, r.`link`, r.`date`
	// 							 FROM `recipe` r
	// 							 JOIN `recipe-category` rc ON r.`row_id` = rc.`recipe_id`
	// 							 JOIN `category` c ON c.`row_id` = rc.`category_id` ";

	// 	if (isset($params["tag"])) {

	// 		$sqlQuery .= "WHERE ";

	// 		foreach ($params["tag"] as $category) {

	// 			foreach ($category as $item) {

	// 				$sqlQuery .= "c.`name` = ? OR ";
	// 				$bindParams[$item] = "s";

	// 			}

	// 		}

	// 		$sqlQuery = substr($sqlQuery, 0, strlen($sqlQuery) - 3);

	// 	}
	// 	if (isset($params["title"]) && isset($params["tag"])) {

	// 		$sqlQuery .= "AND r.`title` LIKE '%" . $params["title"] . "%' ";

	// 	}
	// 	else if (isset($params["title"])) {

	// 		$sqlQuery .= "WHERE r.`title` LIKE '%" . $params["title"] . "%' ";

	// 	}
		
		
	// 	$sqlQuery .= "GROUP BY rc.`recipe_id`
	// 								HAVING COUNT(rc.`recipe_id`) >= ? ";
		
	// 	$bindParams[count($bindParams)] = "i";
		
	// 	$sqlQuery .= "ORDER BY r.`$orderField` $orderMethod";

	// 	return $this->db->getQuery($sqlQuery, $returnedRequestFields, $bindParams);

	// }

}
