<?php
/**
 * @author Bhashithe Abeysinghe
 */
abstract class Visitor {
    
    public abstract function login($username, $password);
    
    public function viewData($node)
    {
        //get data from the given node
    }
    
    public function viewNode($node)
    {
        //get node details from the given node
    }
}
