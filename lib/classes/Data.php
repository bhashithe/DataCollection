<?php
/*
 * @author Bhashithe Abeysinghe
 */

abstract class Data 
{
    protected $db;
    protected $value;
    protected $unit;
    protected $sensor_id;
    
    public abstract function read($value, $unit);
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function getUnit()
    {
        return $this->unit;
    }
    
    public function getSensorId()
    {
        return $this->sensor_id;
    }


    public function setUnit($unit)
    {
        $this->unit = $unit;
    }
    
    public function getValueWithTime($time_range) 
    {
        $query = $this->db->prepare("SELECT `time_stamp`, `reading` FROM `data` WHERE `sensor_id` = ? AND `time_stamp` >= ? AND `time_stamp` < ?");
        $query->bindValue(1,$this->getSensorId());
        $query->bindValue(2,$time_range['from']);
        $query->bindValue(3,$time_range['to']);
        
        try
        {
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
    
    public function setValue() 
    {
        $query = $this->db->prepare("SELECT `time_stamp`,`reading` FROM `data` WHERE `sensor_id` = ? ORDER BY `time_stamp` DESC LIMIT 100");
        $query->bindValue(1,$this->getSensorId());
        
        try
        {
            $query->execute();
            
            $this->value = $query->fetchAll();
        } 
        catch (PDOException $e) 
        {
            die($e->getMessage());
        }
    }
}
