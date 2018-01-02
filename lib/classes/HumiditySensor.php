<?php

/*
 * @author Bhashithe Abeysinghe
 */

class HumiditySensor extends Sensor
{
    public function __construct() {
        $this->db = Database::getConnection();
        $this->sensor_type = parent::HUMIDITY;
        $argv = func_get_args();
        
        switch( func_num_args() ) {
            case 1:
                self::__construct1($argv[0]);
                break;
        }
    }
    
    public function __construct1($sensor_id)
    {
        $this->sensor_id = $sensor_id;
        $this->setActivated();
        $this->setNodeId();
        $this->setReadMethod();
                
        $this->data->setUnit('%(No unit)');
    }

    public function setReadMethod() {
        $this->data = new NumericalData($this->getSensorId());
    }
    
    public function performRead($value)
    {
        $this->data->read($value,'NULL');
        $query = $this->db->prepare("INSERT INTO `data` (`sensor_id`,`reading`,`unit`) VALUES(?, ?, ?)");
        $query->bindValue(1,  $this->getSensorId());
        $query->bindValue(2,  $this->data->getValue());
        $query->bindValue(3,  $this->data->getUnit());
        
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
