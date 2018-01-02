<?php
require 'Node.php';
require 'Data.php';
/*
 * @author Bhashithe Abeysinghe
 */

class DataCollector extends User{
    
    private $node;
    private $data;
    
    public function __construct() {
        parent::__construct();
        
        //get users all nodes here
        //assign them to $node
    }


    public function recieveData($data)
    {
        //get the data from the node
        //use validate()
        //insert into database
    }
    
    private function validateData($data)
    {
        //check data 
        //define a validation algo
    }
}
