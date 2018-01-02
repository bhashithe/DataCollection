<?php


/**
 * @author Bhashithe Abeysinghe
 */
class General{
    
    private $db;
    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function logged_in() {
            return(isset($_SESSION['id'])) ? true : false;
    }

    public function file_newpath($path, $filename){
            if ($pos = strrpos($filename, '.')) {
               $name = substr($filename, 0, $pos);
               $ext = substr($filename, $pos);
            } else {
               $name = $filename;
            }

            $newpath = $path.'/'.$filename;
            $newname = $filename;
            $counter = 0;

            while (file_exists($newpath)) {
               $newname = $name .'_'. $counter . $ext;
               $newpath = $path.'/'.$newname;
               $counter++;
            }

            return $newpath;
    }

    public function getLocations() {
        $query = $this->db->prepare("SELECT * FROM `geo_coord`");

        try{
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $ex) {

        }
    }
    
    public function getRandomNodes()
    {
        $query = $this->db->prepare("SELECT `node_id` FROM `node` ORDER BY RAND() LIMIT 9");
        
        try
        {
            $query->execute();
            return $query->fetchAll();
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
    
    public function getAllNodes()
    {
        $query = $this->db->prepare("SELECT `node_id` FROM `node`");
        
        try
        {
            $query->execute();
            return $query->fetchAll();
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
}
