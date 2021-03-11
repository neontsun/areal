<?php 

namespace application\models;

use application\core\Model;

class RecipeModel extends Model {

	/* Получение всех рецептов */
	public function getAllRecipes($orderField = "row_id", $orderMethod = "DESC") {

		$returnedRequestFields = [
			'row_id',
			'title',
			'description',
			'like_count',
			'link',
			'date'
		];

		$sqlQuery = "SELECT r.`row_id`, r.`title`, r.`description`, r.`like_count`, r.`link`, r.`date`
							   FROM `recipe` r
								 ORDER BY `$orderField` $orderMethod";

		return $this->db->getQuery($sqlQuery, $returnedRequestFields, []);

	}

	/* Получение рецепта по id */
	public function getFullRecipeDataById($recipeId) {

		$returnedRequestFields = [
			'row_id',
			'title',
			'time_cooking',
			'description',
			'ingredients',
			'text',
			'like_count',
			'date',
			'link',
		];

		$sqlQuery = "SELECT * 
						FROM `recipe` 
						WHERE `row_id` = ?";

		$bindParams = [$recipeId => "i"];

		return $this->db->getQuery($sqlQuery, $returnedRequestFields, $bindParams);

	}
	
	/* Получение количества рецептов */
	public function getRecipesCount() {

		$returnedRequestFields = [
			"count"
		];

		$sqlQuery = "SELECT COUNT(r.`row_id`) 
								 FROM `recipe` r";

		$recipeCount = $this->db->getQuery($sqlQuery, $returnedRequestFields, [])[0];

		return $recipeCount;

	}

	/* Получение ссылок всех рецептов */ 
	public function getRecipesLinks() {

		$returnedRequestFields = [
			"link"
		];

		$sqlQuery = "SELECT r.`link` 
								 FROM `recipe` r";
		
		return $this->db->getQuery($sqlQuery, $returnedRequestFields, []);

	}

	/* Получение рецепта в соответствии с параметрами запроса */
	public function getRecipeByFilter($params, $orderField = "row_id", $orderMethod = "DESC") {
		
		$returnedRequestFields = [
			'row_id',
			'title',
			'description',
			'like_count',
			'link',
			'date'
		];
		$bindParams = [];

		$sqlQuery = "SELECT r.`row_id`, r.`title`, r.`description`, r.`like_count`, r.`link`, r.`date`
								 FROM `recipe` r
								 JOIN `recipe-category` rc ON r.`row_id` = rc.`recipe_id`
								 JOIN `category` c ON c.`row_id` = rc.`category_id` ";

		if (isset($params["tag"])) {

			$sqlQuery .= "WHERE ";

			foreach ($params["tag"] as $category) {

				foreach ($category as $item) {

					$sqlQuery .= "c.`name` = ? OR ";
					$bindParams[$item] = "s";

				}

			}

			$sqlQuery = substr($sqlQuery, 0, strlen($sqlQuery) - 3);

		}
		if (isset($params["title"]) && isset($params["tag"])) {

			$sqlQuery .= "AND r.`title` LIKE '%" . $params["title"] . "%' ";

		}
		else if (isset($params["title"])) {

			$sqlQuery .= "WHERE r.`title` LIKE '%" . $params["title"] . "%' ";

		}
		
		
		$sqlQuery .= "GROUP BY rc.`recipe_id`
									HAVING COUNT(rc.`recipe_id`) >= ? ";
		
		$bindParams[count($bindParams)] = "i";
		
		$sqlQuery .= "ORDER BY r.`$orderField` $orderMethod";

		return $this->db->getQuery($sqlQuery, $returnedRequestFields, $bindParams);

	}

}
