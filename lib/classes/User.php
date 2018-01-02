<?php

require 'Visitor.php';
require 'Node.php';

/**
 * @author Bhashithe Abeysinghe
 */
class User extends Visitor {
    //* has getters and setters(setters via database only)
    protected $db;
    protected $username; //*
    protected $email; //*
    protected $confirmed;//*
    protected $nodes;
    protected $id;
    protected $freq; //*
    
    public function __construct() {
        $this->db = Database::getConnection();
        $argv = func_get_args();
        
        switch( func_num_args() ) {
            case 0: 
                self::__construct1();
                break;
            case 1:
                self::__construct2($argv[0]);
                break;
         }
    }

    public function __construct1()
    {
        if($this->loggedIn())
        {
            $this->id = $_SESSION['id'];
            $this->setUsername($this->getUserId());
            $this->setEmail($this->getUserId());
            $this->setConfirmed($this->getUserId());
            
            if($this->confirmed && $this->hasNodes() && $this->getUserId() == $_SESSION['id'])
                $this->nodes = $this->getNodes();
        }
    }
    
    public function __construct2($id)
    {        
        $this->id = $id;
        $this->setUsername($id);
        $this->setEmail($id);
        $this->setConfirmed($id);
        
        if ($this->getConfirmed() && $this->hasNodes()) {
            $this->nodes = $this->getNodes();
        }
    }

    
    public function getUsername()
    {
        return $this->username;        
    }
    
    public function getEmail()
    {        
        return $this->email;
    }
    
    public function getConfirmed()
    {
        return $this->confirmed;
    }
    
    public function setUsername($id)
    {
        $query = $this->db->prepare("SELECT `username` FROM `user` WHERE `id` = ?");
        $query->bindValue(1,$id);

        try 
        {
            $query->execute();

            $this->username =  $query->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }  
    }
    
    public function setConfirmed($id)
    {
        $query = $this->db->prepare("SELECT `confirmed` FROM `user` WHERE `id` = ?");
        $query->bindValue(1,$id);

        try {
            $query->execute();

            $this->confirmed =  $query->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }  
    }
    
    public function setEmail($id)
    {
        $query = $this->db->prepare("SELECT `email` FROM `user` WHERE `id` = ?");
        $query->bindValue(1,$id);

        try {
            $query->execute();

            $this->email =  $query->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }  
    }
    
    public function setFreq($id)
    {
        $query = $this->db->prepare("SELECT `freq` FROM `user` WHERE `id` = ?");
        $query->bindValue(1,$id);

        try {
            $query->execute();

            $this->freq =  $query->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }  
    }

    public function addNode($node_name,$node_type,$location)
    {
        //create a node, insert its details to database
        //new node object is not nesessary here, we are only adding nodes details to the database
        
        if($this->getConfirmed())
        {
            $uniq_str = uniqid(str_shuffle('cs304_this_is_bhashithe_abeysinghe_'),true);
            $query = $this->db->prepare("INSERT INTO `node` (`node_name`,`node_type`, `location`,`uniq_str`) VALUES(?,?,?,?)");
            $query->bindValue(1,$node_name);
            $query->bindValue(2,$node_type);
            $query->bindValue(3,$location);
            $query->bindValue(4,$uniq_str);
            try
            {
                $query->execute();
                $id = $this->db->lastInsertId();

                $query2 = $this->db->prepare("INSERT INTO `user_node` (`node_id`, `user_id`) VALUES(?,?)");
                $query2->bindValue(1,$id);
                $query2->bindValue(2,  $this->getUserId());

                $query2->execute();
            } 
            catch (PDOException $e) 
            {
                die($e->getMessage());
            }

            header("location: node_data.php?id=$id");
            
        }
        else
        {
            header("location:profile.php?not_confirmed");   
        }
    }
    
    public function getNodes()
    {
        $query = $this->db->prepare("SELECT `node_id` FROM `user_node` WHERE `user_id` = ?");
        $query->bindValue(1,  $this->getUserId());
        try
        {
            $query->execute();
            
            $node_data = $query->fetchAll();
            $nodes = NULL;
           foreach ($node_data as $node_ids) 
            {
               $nodes[]=new Node($node_ids['node_id']);
            }
            
            return $nodes;
            
        } catch (PDOException  $e) {
            die($e->getMessage());
        }
    }
    
    public function getFreq() 
    {
        return $this->freq;
    }
    
    public function isAdmin()
    {
        $query = $this->db->prepare("SELECT `type` FROM `user` WHERE `id` = ?");
        $query->bindValue(1, $this->getUserId());
        
        try
        {
            $query->execute();
            $result = $query->fetchColumn();
            
            if($result=='admin')
                return true;
            else
                return false;
            
        }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }


    public function deleteNode($node_id)
    {
        //here dedlete the node if the node is owned by the user
        //check ownership
        //admins delete should override this
        $node = new Node($node_id);
        $owner = new User($node->getOwnerId());
        if($this == $owner)
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
    
    public function addSensor(Node $node,$sensor)
    {
        $owner = new User($node->getOwnerId());
        if($this == $owner)
        {    
            $query = $this->db->prepare("INSERT INTO `sensor` (`node_id`,`sensor_type`) VALUES(?,?)");
            $query->bindValue(1,$node->getNodeId());
            $query->bindValue(2,$sensor->getType());

            try
            {
                $query->execute();
            } 
            catch (PDOException $e)
            {
                die($e->getMessage());
            }
            
            return $this->db->lastInsertId();
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
        if($this==$owner)
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
    
    public function deleteSensor(Node $node,$sensor_id) 
    {
        //this will remove the sensor ownership from the node => the node cannot access the sensor, only an admin can remove the sensor and its data
        $owner = new User($node->getOwnerId());
        if($this == $owner)
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
    
    public function toggleSensor(Node $node,$sensor_id) 
    {
        $owner = new User($node->getOwnerId());
        if($owner == $this)
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

    public final function register($username, $password, $email)
    {
            global $bcrypt;
            $email_code = uniqid(str_shuffle('cs304_this_is_bhashithe_abeysinghe_'),true);
            $password   = $bcrypt->genHash($password);
           // echo $email;
            if(!$this->email_exists($email))
            {
                if(!$this->user_exists($username))
                {
                    $query = $this->db->prepare("INSERT INTO `user` (`username`, `password`, `email`, `email_code`) VALUES (?, ?, ?, ?) ");
                    $query->bindValue(1, $username);
                    $query->bindValue(2, $password);
                    $query->bindValue(3, $email);
                    $query->bindValue(4, $email_code);

                    try 
                    {
                            $query->execute();
                            //send mail
                            //mail($email,"Activate your Account at Weather Center','Please click the following link if you have registered this e-mail with us. Otherwise, ignore this e-mail.\r\nhttp://www.weathercenter.lk/activate.php?email=".$email."&code=".$email_code);
                    } catch (PDOException $e) {
                            die($e->getMessage());
                            //header("location: "); SET LATER
                    }
                    
                }
                else
                {
                    unset($query);
                    header("location: register.php?user_exists");
                }
            }
            else
            {
                header("location: register.php?email_exists");
            }
    }
    
    private final function user_exists($username) 
    {
        $query = $this->db->prepare("SELECT COUNT(`id`) FROM `user` WHERE `username`= ?");
        $query->bindValue(1, $username);

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
    
    private final function email_exists($email) 
    {
        $query = $this->db->prepare("SELECT COUNT(`id`) FROM `user` WHERE `email`= ?");
        $query->bindValue(1, $email);

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
        
        unset($query);
    }
    
    public function loggedIn()
    {
            if(!empty($_SESSION['id']))
            {
                    return true;
            }
            else
            {
                    return false;
            }
    }
    
    public function login($username, $password) 
    {
            if($this->user_exists($username))
            {
                global $bcrypt;

                $query = $this->db->prepare("SELECT `password`, `id` FROM `user` WHERE `username` = ? LIMIT 1");
                $query->bindValue(1, $username);

                try{

                        $query->execute();
                        $data = $query->fetch();
                        $stored_password = $data['password'];
                        $id = $data['id'];

                        if($bcrypt->verify($password, $stored_password) === true){
                                return $id;
                        }else{
                                return false;
                        }

                }catch(PDOException $e){
                        die($e->getMessage());
                        unset($query);
                        header("location:login.php?login_error");
                }
            }
            else
            {
                unset($query);
                header("location:login.php?username_error");
            }
            unset($query);
    }

    public function activate($email, $email_code) 
    {
            $query = $this->db->prepare("SELECT COUNT(`id`) FROM `user` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");

            $query->bindValue(1, $email);
            $query->bindValue(2, $email_code);
            $query->bindValue(3, 0);

            try{

                    $query->execute();
                    $rows = $query->fetchColumn();

                    if($rows == 1){

                            $query_2 = $this->db->prepare("UPDATE `user` SET `confirmed` = ? WHERE `email` = ?");

                            $query_2->bindValue(1, 1);
                            $query_2->bindValue(2, $email);

                            $query_2->execute();
                            //Send mail
                            unset($query);
                            unset($query_2);
                            return true;

                    }else{
                            return false;
                    }

            } catch(PDOException $e){
                    die($e->getMessage());
            }

    }

    public function email_confirmed($username)
    {
            $query = $this->db->prepare("SELECT COUNT(`id`) FROM `user` WHERE `username`= ? AND `confirmed` = ?");
            $query->bindValue(1, $username);
            $query->bindValue(2, 1);

            try{

                    $query->execute();
                    $rows = $query->fetchColumn();

                    if($rows == 1){
                        unset($query);
                        return true;
                    }else{
                        unset($query);
                        return false;
                    }

            } catch(PDOException $e){
                    die($e->getMessage());
            }

    }
    
    public function update_user($first_name, $last_name, $image_loc, $username)
    {
            $dob = date("Y-m-d", strtotime($dob));

            $query = $this->db->prepare("UPDATE `additional_details` SET `first_name` = ?,`last_name` = ?, `image_loc` = ? WHERE `username` = ?");

            $query->bindValue(1, $first_name);
            $query->bindValue(2, $last_name);
            $query->bindValue(3, $image_loc);
            $query->bindValue(4, $username);
            try
            {
                    $query->execute();
            }
            catch(PDOException $e)
            {
                    die($e->getMessage());
                    //header("location:"); SET LATER
            }
            unset($query);
    }
    
    public function change_password($username, $password) 
    {
        global $bcrypt;

        $password_hash = $bcrypt->genHash($password);

        $query = $this->db->prepare("UPDATE `user` SET `password` = ? WHERE `username` = ?");

        $query->bindValue(1, $password_hash);
        $query->bindValue(2, $username);

        try{
                $query->execute();
                //send mail
                unset($query);
                return true;
        } catch(PDOException $e){
                die($e->getMessage());
        }

    }

    public function recover($email, $generated_string) 
{
        if($generated_string == 0)
        {
                return false;
        }
        else
        {

            $query = $this->db->prepare("SELECT COUNT(`id`) FROM `user` WHERE `email` = ? AND `generated_string` = ?");

            $query->bindValue(1, $email);
            $query->bindValue(2, $generated_string);

            try{

                    $query->execute();
                    $rows = $query->fetchColumn();

                    if($rows == 1){

                            global $bcrypt;

                            $username = $this->fetch_info('username', 'email', $email); // getting username for the use in the email.
                            $user_id  = $this->fetch_info('id', 'email', $email);

                            $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                            $generated_password = substr(str_shuffle($charset),0, 10);

                            $this->change_password($user_id, $generated_password);

                            $query = $this->db->prepare("UPDATE `user` SET `generated_string` = 0 WHERE `id` = ?");

                            $query->bindValue(1, $user_id);

                            $query->execute();
                            unset($query);
                            //send email

                    }else{
                            unset($query);
                            return false;
                    }

            } 
            catch(PDOException $e)
            {
                    die($e->getMessage());
            }
        }
    }
        
    public function confirm_recover($email)
    {
            $username = $this->fetch_info('username', 'email', $email);

            $unique = uniqid('',true); //unix time stamp
            //TODO check if mt_rand() is a better option or not
            $random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0, 10); 

            $generated_string = $unique . $random;

            $query = $this->db->prepare("UPDATE `user` SET `generated_string` = ? WHERE `email` = ?");

            $query->bindValue(1, $generated_string);
            $query->bindValue(2, $email);

            try{

                    $query->execute();
                    unset($query);
                    mail($email, 'Recover Password', "Hello " . $username. ",\r\nPlease click the link below:\r\n\r\nhttp://www.weathercenter.lk/recover.php?email=" . $email . "&generated_string=" . $generated_string . "\r\n\r\n We will generate a new password for you and send it back to your email. \nIf you did not request for a new password, please contact us Immediately \r\n\r\n-- Ceylonese Connection team",null,"-fnoreply@ceyloneseconnection.com");

            } catch(PDOException $e){
                    die($e->getMessage());
            }
    }

    public function getUserId() 
    {
        return $this->id;
    }

    public function hasNodes()
    {
        $query = $this->db->prepare("SELECT COUNT(*) FROM `user_node` WHERE `user_id` = ?");
        $query->bindValue(1,  $this->getUserId());
        
        try 
        {
            $query->execute();            
            $data = $query->fetchColumn();
            unset($query);
            if($data==0)
            {
                return false;
            }
            else
            {
                return true;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    public function exportCsv($result)
    {
        if(!isset($result))
        {
            die("no data");
        }
        
        $fp = fopen('php://output', 'w');
        
        if($fp && $result)
        {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="export.csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
            
            foreach ($result as $value) 
            {
                fputcsv($fp, $value);
            }
            
            die;
        }
    }
}