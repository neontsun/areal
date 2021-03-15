<?php

namespace application\core;
use Exception;
use mysqli;

class DataBase {

	private $mysqli;

	public function __construct() {

		$db = require 'application/config/db.php';
		$this->mysqli = new mysqli(
			$db["DB_HOST"], 
			$db["DB_USER"], 
			$db["DB_PASSWORD"], 
			$db["DB_NAME"]
		);

		if ($this->mysqli->connect_error) {
			
			throw new Exception(
				"Не удалось подключиться к базе данных: " . 
				$this->mysqli->connect_error
			);
			
		}

	}
	
	// Запрос выборки
	public function getQuery($query, $returnedField, $prepareParams) {
		
		$statement = $this->mysqli->prepare($query);
		
		if ($statement) {
			
			if ($prepareParams) {
				
				$prepareTypes = "";
				$prepareValue = [];
				
				foreach ($prepareParams as $parameter) {
					
					$prepareTypes .= $parameter[1];
					$prepareValue[] = $parameter[0];
					
				}
				
				$statement->bind_param($prepareTypes, ...$prepareValue);
				
			}

			$statement->execute();

			$result = $statement->get_result();
			$returnedData = [];
			
			if ($result->num_rows != 0) {
				
				while ($row = $result->fetch_array(MYSQLI_NUM)) {
					
					if (count($row) == count($returnedField)) {
						
						$temp = [];
						
						for ($i = 0; $i < count($row); $i++) { 
							
							$temp[$returnedField[$i]] = $row[$i];
							
						}
						
						$returnedData[] = $temp;
						
					}
					else 
						throw new Exception('Количество возвращаемых полей не 
							соответствует количеству указанных');
					
				}
				
				$result->close();
				
			}
			
		}
		else 
			throw new Exception("Ошибка запроса: " . $this->mysqli->error);

		return $returnedData;

	}
	
	// Запрос добавления
	public function postQuery($query, $prepareParams) {
		
		$statement = $this->mysqli->prepare($query);
		
		if ($statement) {
			
			if ($prepareParams) {
				
				$prepareTypes = "";
				$prepareValue = [];
				
				foreach ($prepareParams as $parameter) {
					
					$prepareTypes .= $parameter[1];
					$prepareValue[] = $parameter[0];
					
				}

				$statement->bind_param($prepareTypes, ...$prepareValue);
				
			}
			
			$statement->execute();
			$statement->close();
			
		}
		else 
			throw new Exception("Ошибка запроса: " . $this->mysqli->error);
	
	}
	
}
