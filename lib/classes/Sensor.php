<?php
/**
 * @author Bhashithe Abeysinghe
 */
abstract class Sensor {
    protected $data;
    protected $sensor_id;
    protected $db;
    protected $activated;
    protected $node_id;


    /*
     * Sensor types
     */
    const PRESSURE = "pressure";
    const TEMPERATURE = "temperature";
    const HUMIDITY = "humidity";

    /*
     * stratergy pattern
     * read method is a object of type Data
     * set this in extended sensor objects in runtime
     */    
    public abstract function setReadMethod();
    public abstract function performRead($value);

    public function getData()
    {
        return $this->data;
    }

    public function getSensorId() {
        return $this->sensor_id;
    }
    
    public function getType() {
        return $this->sensor_type;
    }

    public function getActivated()
    {
        return $this->activated;
    }
    
    public function getNodeId() 
    {
        return $this->node_id;
    }
    
    public function getUnit() 
    {
        return $this->unit;
    }
    
    public static function getSensorTypeForId($sensor_id)
    {
        $query = Database::getConnection()->prepare("SELECT `sensor_type` FROM `sensor` WHERE `sensor_id` = ?");
        $query->bindValue(1,$sensor_id);
        
        try 
        {
            $query->execute();
            
            return $query->fetchColumn();
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
    
    public function getLastRead()
    {
        $query = $this->db->prepare("SELECT `reading` FROM `data`  WHERE `sensor_id` = ? ORDER BY `time_stamp` DESC LIMIT 1");
        $query->bindValue(1, $this->getSensorId());
        
        try 
        {
            $query->execute();
            return $query->fetchColumn();
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }


    public function setActivated()
    {
        $query = $this->db->prepare("SELECT `activated` FROM `sensor`  WHERE `sensor_id` = ?");
        $query->bindValue(1, $this->getSensorId());
        
        try 
        {
            $query->execute();
            $this->activated = $query->fetchColumn();
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
    
    public function setNodeId()
    {
        $query = $this->db->prepare("SELECT `node_id` FROM `sensor`  WHERE `sensor_id` = ?");
        $query->bindValue(1, $this->getSensorId());
        
        try 
        {
            $query->execute();
            $this->node_id = $query->fetchColumn();
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
    
    public static function isSensor($id)
    {
        $query = Database::getConnection()->prepare("SELECT COUNT(`sensor_id`) FROM `sensor`  WHERE `sensor_id` = ?");
        $query->bindValue(1, $id);
        
        try 
        {
            $query->execute();
            $result = $query->fetchColumn();
            
            if($result==1)
                return true;
            else
            {
                return false;
            }
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
}