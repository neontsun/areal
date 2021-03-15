<?php

namespace application\core;
use application\core\DataBase;

abstract class Model {

	protected $db;

	public function __construct() {

		$this->db = new DataBase();
		
	}

}
