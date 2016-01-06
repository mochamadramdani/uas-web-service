<?php

namespace App\Db;

use PDO;

class Connection extends PDO{
	public function __construct(){
		parent::__construct('mysql:host=localhost;dbname=uas','root','');
    }
}