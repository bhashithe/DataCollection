<?php
require 'Data.php';
/*
 * @author Bhashithe Abeysinghe
 */

//something here

class NumericalData extends Data 
{
    
    public function __construct($sensor_id) 
    {
        $this->db = Database::getConnection();
        $this->sensor_id=$sensor_id;
        $this->setValue();
    }

    public function read($value, $unit) 
    {
        $this->value = $value;
        $this->unit = $unit;
    }
}
