<?php

namespace App\Routes;

use PDO;
use PDOException;

use Slim\Slim;
use App\Db\Connection;

class Laptop {
    
	function index() {
		$app = Slim::getInstance();
		
		try {
			$db = new Connection();
			$sth = $db->prepare("SELECT * FROM laptops");
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
			$sth = $db->prepare("SELECT * FROM laptops WHERE id = :id");
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
		$brand = $request['brand'];
		$model = $request['model'];
		$year = $request['year'];
		
		try {
			$db = new Connection();
			$sth = $db->prepare("INSERT INTO laptops (`brand`,`model`,`release_year`) VALUES (:brand,:model,:year)");
 
			$sth->bindParam('brand', $brand);
			$sth->bindParam('model', $model);
			$sth->bindParam('year', $year);
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
		$brand = $request['brand'];
		$model = $request['model'];
		$year = $request['year'];
		
		try {
			$db = new Connection();
			$sth = $db->prepare("UPDATE laptops SET brand = :brand, model = :model, release_year = :year
            WHERE id = :id");
			
			$sth->bindParam('id', $id);
			$sth->bindParam('brand', $brand);
			$sth->bindParam('model', $model);
			$sth->bindParam('year', $year);
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
			$sth = $db->prepare("DELETE FROM laptops WHERE id = :id");
			
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