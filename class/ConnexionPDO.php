<?php
include_once 'includes/functions.php';

class ConnexionPDO {
    private $host = "localhost";
    private $login = "root";
    private $pass = "root";
    private $db = "db_speedymarket";

    static $instance;

    private function __construct() {
        try{
            self::$instance = new PDO(
                            'mysql:host='.$this->host.';dbname='.$this->db.';charset=utf8',
                            $this->login,
                            $this->pass, 
                            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
                            );
//Renvoi un message d'erreur si la connection échoue
	}catch(Exception $e){
		die('Erreur : '.$e->getMessage());
	}
	return self::$instance;        
    }

    public static function getInstance() {
        if (!(self::$instance)) {
            new ConnexionPDO();
        }
        return self::$instance;
    }

}
