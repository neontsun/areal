<?php

namespace application\core;
use application\core\DataBase;

abstract class Model {

	public $db;

	public function __construct() {

		$this->db = new DataBase;
		
	}

}
