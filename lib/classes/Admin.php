<?php

/*
 * @author Bhashithe Abeysinghe
 */

class Admin extends User{
    //put your code here
    
    public function __construct($id) 
    {
        parent::__construct();
        parent::__construct2($id);
    }
    
    public function deleteSensor(Node $node,$sensor_id) 
    {
        //this will remove the sensor ownership from the node => the node cannot access the sensor, only an admin can remove the sensor and its data
        //deleteSensor admin implementation should insert the deleted sensors details into a table where it records the geo-location of the node and time stamps and readings
        $owner = new User($node->getOwnerId());
        if($this == $owner || $this->isAdmin())
        {    
            $query = $this->db->prepare("UPDATE `sensor` SET `node_id` = NULL WHERE `sensor_id` = ?");
            $query->bindValue(1,$sensor_id);

            try
            {
                $query->execute();
            } 
            catch (PDOException $e)
            {
                die($e->getMessage());
            }
        }
        else
        {
            header("location: add_sensor.php?node_owner_error");
        }
    }
    
    public function updateSensor($node_id, $sensor_type, $sensor_id) 
    {
        $node = new Node($node_id);
        $owner = new User($node->getOwnerId());
        if($this==$owner || $this->isAdmin())
        {
            $query = $this->db->prepare("UPDATE `sensor` SET `node_id` = ?, `sensor_type` = ? WHERE `sensor_id` = ?");
            $query->bindValue(1,$node_id);
            $query->bindValue(2,$sensor_type);
            $query->bindValue(3,$sensor_id);
            
            try
            {
                $query->execute();
            } 
            catch (PDOException $e) 
            {
                die($e->getMessage());
            }
        }
    }
    
    public function deleteNode($node_id)
    {
        $node = new Node($node_id);
        $owner = new User($node->getOwnerId());
        if($this == $owner || $this->isAdmin())
        {
            $query = $this->db->prepare("DELETE FROM `user_node` WHERE `node_id` = ?");
            $query->bindValue(1,$node->getNodeId());
            
            $query2 = $this->db->prepare("DELETE FROM `node` WHERE `node_id` = ?");
            $query2->bindValue(1,$node->getNodeId());
            
            try
            {
                $query->execute();
                $query2->execute();
                
            } 
            catch (PDOException $e) 
            {
                die($e->getMessage());
            }
        }
    }
    
    public function toggleSensor(Node $node,$sensor_id) 
    {
        $owner = new User($node->getOwnerId());
        if($owner == $this || $this->isAdmin())
        {
            $query = $this->db->prepare("SELECT `activated` FROM `sensor` WHERE `sensor_id` = ?");
            $query->bindValue(1,$sensor_id);

            try
            {
                $query->execute();
                $res = $query->fetchColumn();

                $query = $this->db->prepare("UPDATE `sensor` SET `activated` = ? WHERE `sensor_id` = ?");

                if($res==1)
                {
                    $query->bindValue(1, 0);
                }
                else
                {
                    $query->bindValue(1, 1);
                }

                $query->bindValue(2, $sensor_id);

                $query->execute();
            } 
            catch (PDOException $e) 
            {
                die($e->getMessage());
            }
        }
    }
    
    public function deleteData($sensor_id,$time_range) 
    {
        if($time_range['from']=="" && $time_range['to']=="")
        {
            $query = $this->db->prepare("DELETE FROM `data` WHERE `sensor_id` = ?");
            $query->bindValue(1,$sensor_id);
        }
        else
        {
            $query = $this->db->prepare("DELETE FROM `data` WHERE `sensor_id` = ? AND `time_stamp` >= ? AND `time_stamp` < ?");
            $query->bindValue(1, $sensor_id);
            $query->bindValue(2, $time_range['from']);
            $query->bindValue(3, $time_range['to']);
        }
        
        try
        {
            $query->execute();
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
}
