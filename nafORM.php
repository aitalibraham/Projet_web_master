<?php
require 'db.php';

class NafOrm{
	
	public static function insert($object){
		
		$table = strtolower(get_class($object));
		
		$data = $object->serializeObject();
		unset($data['ID']);
		
		$champs = "";
		$valeurs ="";
		foreach(array_keys($data) as $attribute){
			$champs .= $attribute.", ";
			$valeurs .= ":".$attribute.", ";
		}
		$champs = substr_replace($champs ,"", -2);
		$valeurs = substr_replace($valeurs ,"", -2);
		
		
		$sql = "INSERT INTO ".$table." (".$champs.") VALUES (".$valeurs.")";
		print_r ($data);
		$stmt= DbConnection::getConnection()->prepare($sql);
		$stmt->execute($data);
		$object->setID(DbConnection::getConnection()->lastInsertId());
		return true;
	}
	
	public static function update($object){
		
		$table = strtolower(get_class($object));
		$data = $object->serializeObject();
		
		$update = "";
		
		foreach(array_keys($data) as $attribute){
			if($attribute !="ID"){
				$update .= $attribute."=:".$attribute.", ";
			}
		}
		$update = substr_replace($update ,"", -2);

		
		$sql = "UPDATE ".$table." SET ".$update." WHERE ID=:ID";
		$stmt= DbConnection::getConnection()->prepare($sql);
		$stmt->execute($data);
		return true;
	}
	
	public static function del($object){
		
		$table = strtolower(get_class($object));
		$data = [ "ID" => $object->getID()];
		
		$update = "";
		
		foreach(array_keys($data) as $attribute){
			if($attribute !="ID"){
				$update .= $attribute."=:".$attribute.", ";
			}
		}
		$update = substr_replace($update ,"", -2);

		
		$sql = "DELETE FROM ".$table." WHERE ID=:ID";
		$stmt= DbConnection::getConnection()->prepare($sql);
		$stmt->execute($data);
		return true;
	}

	public static function selectAll($table){
		return DbConnection::getConnection()->query("SELECT * FROM ".$table)->fetchAll();
	}
	
	public static function selectWithCondition($table, $condition){

		$searchcondition = "";
		
		foreach(array_keys($condition) as $attribute){
			$searchcondition .= $attribute."=:".$attribute.", ";
		}
		
		$searchcondition = substr_replace($searchcondition ,"", -2);
		
		$sql = "SELECT * FROM ".$table." WHERE ".$searchcondition;
		$stmt = DbConnection::getConnection()->prepare($sql);
		$stmt->execute($condition);
		
		return $stmt->fetchAll();
	}
}
class Stage{
	private $domaine;
	
}


?>