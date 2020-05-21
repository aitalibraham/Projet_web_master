<?php
class DbConnection{
	private static $DbInstance = null;
	private static $host = "localhost";
	private static $dbname = "masterapp";
	private static $username = "root";
	private static $pw = "";
	
	private function __construct() {}
	
	public static function getConnection(){
		if(self::$DbInstance == null){
			try{
				self::$DbInstance = new PDO('mysql:host='.self::$host.'; dbname='.self::$dbname.'', self::$username, self::$pw);
			}catch (PDOException $e) {
				print "Erreur !: " . $e->getMessage() . "<br/>";
				die();
			}
		}
			return self::$DbInstance;
	}
	
}
?>