<?php

namespace App\Routes;

use PDO;
use PDOException;

use Slim\Slim;
use App\Db\Connection;

class Parts {
    
	function index() {
		$app = Slim::getInstance();
		
		try {
			$db = new Connection();
			$sth = $db->prepare("SELECT * FROM parts");
			$sth->execute();
	 
			$laptop = $sth->fetchAll(PDO::FETCH_OBJ);
	 
			if($laptop) {
				$app->response->setStatus(200);
				$app->response()->headers->set('Content-Type', 'application/json');
				echo json_encode($laptop);
			} else {
				throw new PDOException('No records found.');
			}
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	function view($id) {
		$app = Slim::getInstance();
		try {
			$db = new Connection();
			$sth = $db->prepare("SELECT * FROM parts WHERE id = :id");
			$sth->bindParam('id', $id);
			$sth->execute();
	 
			$laptop = $sth->fetch(PDO::FETCH_OBJ);
	 
			if($laptop) {
				$app->response->setStatus(200);
				$app->response()->headers->set('Content-Type', 'application/json');
				echo json_encode($laptop);
			} else {
				throw new PDOException('Data not found.');
			}
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	
	function create() {
		$app = Slim::getInstance();
		
        $request = $app->request->post();
		$laptop_id = $request['laptop_id'];
		$part_category = $request['part_category'];
		$part_number = $request['part_number'];
		$description = $request['description'];
		
		try {
			$db = new Connection();
			$sth = $db->prepare("INSERT INTO parts (`laptop_id`,`part_category`,`part_number`,`description`) VALUES (:laptop_id,:part_category,:part_number,:description)");
 
			$sth->bindParam('laptop_id', $laptop_id);
			$sth->bindParam('part_category', $part_category);
			$sth->bindParam('part_number', $part_number);
			$sth->bindParam('description', $description);
			$sth->execute();
	 
			$app->response->setStatus(200);
			$app->response()->headers->set('Content-Type', 'application/json');
			echo json_encode(array("status" => "success", "code" => 1));
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	function update() {
		$app = Slim::getInstance();
		
        $request = $app->request->put();
		$id = $request['id'];
		$laptop_id = $request['laptop_id'];
		$part_category = $request['part_category'];
		$part_number = $request['part_number'];
		$description = $request['description'];
		
		try {
			$db = new Connection();
			$sth = $db->prepare("UPDATE parts 
			SET laptop_id = :laptop_id, part_category = :part_category, part_number = :part_number,  description = :description 
            WHERE id = :id");
			
			$sth->bindParam('id', $id);
			$sth->bindParam('laptop_id', $laptop_id);
			$sth->bindParam('part_category', $part_category);
			$sth->bindParam('part_number', $part_number);
			$sth->bindParam('description', $description);
			$sth->execute();
	 
			$app->response->setStatus(200);
			$app->response()->headers->set('Content-Type', 'application/json');
			echo json_encode(array("status" => "success", "code" => 1));
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	function delete() {
		$app = Slim::getInstance();
		
        $request = $app->request->delete();
		$id = $request['id'];
		
		try {
			$db = new Connection();
			$sth = $db->prepare("DELETE FROM parts WHERE id = :id");
			
			$sth->bindParam('id', $id);
			$sth->execute();
	 
			$app->response->setStatus(200);
			$app->response()->headers->set('Content-Type', 'application/json');
			echo json_encode(array("status" => "success", "code" => 1));
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
	
	function find() {
		$app = Slim::getInstance();
        $request = $app->request->get();
		
		try {
			$db = new Connection();
			$sql = "SELECT * FROM laptops ";
			$where = [];
			
			foreach($request as $name => $value) {
				$where[] = $name." = :".$name;
			}
			
			if(count($where) > 0){
				$sql .= 'WHERE ' . implode(' AND ', $where);
			}
			
			$sth = $db->prepare($sql);
			foreach($request as $name => $value) {
				$sth->bindParam($name, $value);
			}
			$sth->execute();
	 
			$laptop = $sth->fetchAll(PDO::FETCH_OBJ);
	 
			if($laptop) {
				$app->response->setStatus(200);
				$app->response()->headers->set('Content-Type', 'application/json');
				echo json_encode($laptop);
			} else {
				throw new PDOException('No records found.');
			}
		} catch(PDOException $e) {
			$app->response()->setStatus(404);
			echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
	}
}