<?php

require 'Sensor.php';
require 'SensorFactory.php';
require 'TemperatureSensor.php';
require 'HumiditySensor.php';
require 'PressureSensor.php';

/**
 * @author Bhashithe Abeysinghe
 */
class Node {
    private $db;
    private $node_id;
    private $node_name;
    private $location;
    private $node_type;    
    private $sensors;
    private $owner; //type user, changed to owner_id since recursively calling both objects
    private $uniq_str;
    private $last_upload;
    
    public function __construct() {
        $this->db = Database::getConnection();
        $argv = func_get_args();
        
        switch( func_num_args() ) {
            case 1:
                self::__construct1($argv[0]);
                break;
         }
    }
    
    public function __construct1($id)
    {
        $this->node_id = $id;
        $this->setName($id);
        $this->setOwnerId($id);
        $this->setUniqStr($id);
        $this->setType($id);
        $this->setLastUpload($id);
    }

    public function getDetails()
    {
        $query = $this->db->prepare("SELECT `node_id`,`node_name`,`location`,`node_type`,`uniq_str` FROM `node` WHERE `node_id` = ?");
        $query->bindValue(1, $this->node_id);
        
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
    
    public function getOwnerId() {
        return $this->owner;
    }
    
    public function getLastUpload()
    {
        return $this->last_upload;
    }

        public function hasSensors() 
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM `sensor` WHERE `node_id` = ?");
        $query->bindValue(1,  $this->getNodeId());
        
        try
        {
            $query->execute();
            $data = $query->fetchColumn();
            
            return $data>0 ? true : false;
        } catch (PDOException $ex) {
            die($ex->getMessage());
        }
    }

    public function addSensor($sensor_type)
    {
        $query = $this->db->prepare("INSERT INTO `sensor` (`node_id`,`sensor_type`) VALUES(?,?)");
        $query->bindValue(1, $this->getNodeId());
        $query->bindValue(2, $sensor_type);
        
        try            
        {
            $query->exeute();
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }
    
    public static function isNode($id)
    {
        $query = Database::getConnection()->prepare("SELECT COUNT(`node_id`) FROM `node` WHERE `node_id`= ?");
        $query->bindValue(1, $id);

        try{

                $query->execute();
                $rows = $query->fetchColumn();

                if($rows == 1){
                        return true;
                }else{
                        return false;
                }

        } catch (PDOException $e){
                die($e->getMessage());
        }
    }
    
    public function getSensors()
    {
        $query = $this->db->prepare("SELECT `sensor_id`,`sensor_type` FROM `sensor` WHERE `node_id` = ?");
        $query->bindValue(1,  $this->getNodeId());
        
        try
        {
            $query->execute();
            $data = $query->fetchAll();
            $sensors = NULL;
            $senor_factory = new SensorFactory();
            foreach ($data as $value) {
                $sensors[] = $senor_factory->getSensorObjectWithId($value['sensor_type'], $value['sensor_id']);
            }
            
            return $sensors;
            
        } catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
    
    
    
    public function getSensorCount()
    {
        $query = $this->db->prepare("SELECT COUNT(`sensor_id`) FROM `sensor` WHERE `node_id` = ?");
        $query->bindValue(1,  $this->getNodeId());
        
        try
        {
            $query->execute();
            $data = $query->fetchColumn();
            
            return $data;
            
        } catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
    
    public function getLocation()
    {
        return $this->location;
    }

    public function getNodeId() {
        return $this->node_id;
    }
    
    public function getUniqStr() {
        return $this->uniq_str;
    }
    
    public function getType() {
        return $this->node_type;
    }
    
    public function getName() {
        return $this->node_name;
    }
    
    public function setName($id) 
    {
        $query = $this->db->prepare("SELECT `node_name` FROM `node` WHERE `node_id` = ?");
        $query->bindValue(1,$id);
        
        try
        {
           $query->execute();
           $this->node_name = $query->fetchColumn();
        }
        catch(PDOException $e)
        {
           die($e->getMessage());
        }
    }
    
    public function setUniqStr($id) 
    {
        $query = $this->db->prepare("SELECT `uniq_str` FROM `node` WHERE `node_id` = ?");
        $query->bindValue(1,$id);
        
        try
        {
            $query->execute();
            $this->uniq_str = $query->fetchColumn();
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
    }
    
    public function setType($id) 
    {
        $query = $this->db->prepare("SELECT `node_type` FROM `node` WHERE `node_id` = ?");
        $query->bindValue(1,$id);
        
        try
        {
            $query->execute();
            $this->node_type = $query->fetchColumn();
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
    }
    
    public function setOwnerId($id) 
    {
        $query = $this->db->prepare("SELECT `user_id` FROM `user_node` WHERE `node_id` = ?");
        $query->bindValue(1,$id);
        
        try
        {
            $query->execute();
            $this->owner= $query->fetchColumn();
            //$this->owner = new User($owner_id);
        }
        catch(PDOException $e)
        {
            die($e->getMessage());
        }
    }
    
    public static function checkDeviceValidity($device_id) 
    {
        $query = Database::getConnection()->prepare("SELECT COUNT(`node_id`) FROM `node` WHERE `uniq_str` = ?");
        $query->bindValue(1,$device_id);
        try
        {
            $query->execute();
            
            $data = $query->fetchColumn();
            
            if($data==0)
            {
                return false;
            }
            else if($data==1)
            {
                return true;
            }
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
    
    public static function getNodeIdFromDeviceId($device_id) 
    {
        $query = Database::getConnection()->prepare("SELECT `node_id` FROM `node` WHERE `uniq_str` = ?");
        $query->bindValue(1,$device_id);
        
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
    
    public function getActiveSensors()
    {
        $query = $this->db->prepare("SELECT `sensor_id`,`sensor_type` FROM `sensor` WHERE `node_id` = ? AND `activated` = 1");
        $query->bindValue(1,  $this->getNodeId());
        
        try
        {
            $query->execute();
            $data = $query->fetchAll();
            $sensors = NULL;
            $senor_factory = new SensorFactory();
            foreach ($data as $value) {
                $sensors[] = $senor_factory->getSensorObjectWithId($value['sensor_type'], $value['sensor_id']);
            }
            
            return $sensors;
            
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }

    public function setLastUpload($id) 
    {        
        $query = $this->db->prepare("SELECT `time_stamp` FROM `node` WHERE `node_id` = ?");
        $query->bindValue(1,$id);
        
        try
        {
           $query->execute();
           $this->last_upload = $query->fetchColumn();
        }
        catch(PDOException $e)
        {
           die($e->getMessage());
        }
    }
    
    public function setCurruentUpload()
    {
        $query = $this->db->prepare("UPDATE `node` SET `time_stamp` = NOW() WHERE `node_id` = ?");
        $query->bindValue(1, $this->getNodeId());
        
        try
        {
           $query->execute();
        }
        catch(PDOException $e)
        {
           die($e->getMessage());
        }
    }
    
    public function checkUpload(User $user)
    {
        $query = $this->db->prepare("SELECT NOW() - `time_stamp` FROM `node` WHERE `node_id` = ?");
        $query->bindValue(1, $this->getNodeId());
        
        try
        {
           $query->execute();
           $time = $query->fetchColumn();
           
           if($time>$user->getFreq()) //take frequency from user
           {
               return true;
           }
           else
           {
               return false;
           }
        }
        catch(PDOException $e)
        {
           die($e->getMessage());
        }
    }
}