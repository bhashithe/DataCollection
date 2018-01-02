<?php
/*
 * @author Bhashithe Abeysinghe
 */
require 'Data.php';

class CategoricalData extends Data
{
    
    public function __construct() 
    {
        $this->db = Database::getConnection();
    }

    public function read($value, $unit) 
    {
        $this->value = $value;
        $this->unit = $unit;
    }
}
