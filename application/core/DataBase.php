<?php

namespace application\core;
use Exception;
use mysqli;

class DataBase {

	private $mysqli;

	public function __construct() {

		$db = require 'application/config/db.php';
		$this->mysqli = new mysqli($db["DB_HOST"], $db["DB_USER"], $db["DB_PASSWORD"], $db["DB_NAME"]);

		if ($this->mysqli->connect_error) {
			throw new Exception("Не удалось подключиться к базе данных: " . $this->mysqli->connect_error);
		}

	}
	
	// Запрос выборки
	public function getQuery($sqlQuery, $returnedRequestFields, $bindParams) {
		
		if ($queryStatement = $this->mysqli->prepare($sqlQuery)) {
			
			if ($bindParams) {
				
				$types = "";
				$bindValue = [];
				
				foreach ($bindParams as $param) {
					$types .= $param[1];
					$bindValue[] = $param[0];
				}

				$queryStatement->bind_param($types, ...$bindValue);
			}

			$queryStatement->execute();

			$queryResult = $queryStatement->get_result();
			$resultReturnedArray = [];
			
			if ($queryResult->num_rows != 0) {

				while ($resultRow = $queryResult->fetch_array(MYSQLI_NUM)) {
					
					if (count($resultRow) == count($returnedRequestFields)) {
						
						$tempArray = [];
						for ($i = 0; $i < count($resultRow); $i++) { 
							$tempArray[$returnedRequestFields[$i]] = $resultRow[$i];
						}
						$resultReturnedArray[] = $tempArray;
						
					}
					else throw new Exception("Количество возвращаемых полей не соответствует количеству указанных");

				}

				$queryResult->close();
				
			}
			
		}
		else throw new Exception("Ошибка запроса: " . $this->mysqli->error);

		return $resultReturnedArray;

	}
	
	// Запрос добавления
	public function postQuery($sqlQuery, $bindParams) {
		
		if ($queryStatement = $this->mysqli->prepare($sqlQuery)) {
			
			if ($bindParams) {
				
				$types = "";
				$bindValue = [];
				
				foreach ($bindParams as $param) {
					$types .= $param[1];
					$bindValue[] = $param[0];
				}

				$queryStatement->bind_param($types, ...$bindValue);
			}
			
			$queryStatement->execute();
			
			$queryStatement->close();

		}
		else throw new Exception("Ошибка запроса: " . $this->mysqli->error);
	
	}
	
}
