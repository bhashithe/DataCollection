<?php
/*
 * @author Bhashithe Abeysinghe
 */

class Database {
    //adaptor variable 
    private $db;
    
    //singleton instance
    private static $instance=NULL;
    
    private $config = array(
                            'host'      => 'localhost',
                            'username' 	=> 'root',
                            'password' 	=> '',
                            'dbname' 	=> 'weather'
                            );
    
    /*private function __construct() {
        try
        {
            //adaptor
            self::$db = new PDO('mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['dbname'], $this->config['username'], $this->config['password']);
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("connection error");
            exit();
        }
    }*/
    
    private function __construct() {
        try
        {
            //adaptor
            $this->db = new PDO('mysql:host=' . $this->config['host'] . ';dbname=' . $this->config['dbname'], $this->config['username'], $this->config['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
            exit();
        }
    }
    
    /*public static function getConnection()
    {
        if(!isset(self::$db))
        {
            $test= new Database();
        }        
        if(self::$db instanceof PDO)
            return self::$db;
    }*/
    
    public static function getConnection()
    {
        if(self::$instance==NULL)
        {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function prepare($sql)
    {
        return $this->db->prepare($sql);
    }
    
    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
}
