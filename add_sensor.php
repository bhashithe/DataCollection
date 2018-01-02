<?php
    require 'lib/init.php';
    $u_sensor = null;
    $sensor_type = null;
    $u_node = null;
    
    if(!$user->loggedIn())
    {
        header("location: login.php");
    }
    else if(!$user->hasNodes())
    {
        header("location: add_node.php");
    }
    
    if ($user->getConfirmed() && $user->hasNodes() && $user->getUserId() == $_SESSION['id']) 
    {
        $nodes = $user->getNodes();
    }
    else
    {
        header("location: profile.php?not_confirmed_no_nodes");
    }
    
    if(isset($_GET['update']))
    {
        $sensor_id = $_GET['update'];        
        if(!Sensor::isSensor($sensor_id))
        {
            header("location: add_sensor.php");
        }
        $sensor_factory = new SensorFactory(); 
        $sensor_type = Sensor::getSensorTypeForId($sensor_id);
        $u_sensor = $sensor_factory->getSensorObjectWithId($sensor_type, $sensor_id);
        
        $u_node = new Node($u_sensor->getNodeId());
        
    }

    if(isset($_POST['update']) && $_POST['update']== 'update_sensor')
    {
        $sensor_type = htmlentities($_POST['sensor_type']);
        $node_id = htmlentities($_POST['node_id']);
        $user->updateSensor($node_id,$sensor_type,$u_sensor->getSensorId());
        header("location: sensor_data.php?id=".$u_sensor->getSensorId());
    }
    
    if(isset($_POST['submit']) && $_POST['submit']== 'add_sensor')
    {
        $sensor_type = htmlentities($_POST['sensor_type']);
        $node_id = htmlentities($_POST['node_id']);
        $node = new Node($node_id);
        $sensor_factory = new SensorFactory();
        $sensor = $sensor_factory->getSensorObject($sensor_type);
        $id=$user->addSensor($node,$sensor);
        //relocate to sensor page
        header("location: sensor_data.php?id=$id");
    }
    
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php
            include 'reqs/head.php';
        ?>
        <title><?php if(isset($_GET['update'])) {echo "Update Sensor | WeatherCenter";} else {echo "Create Sensors | Weather Center";}?></title>
    </head>
    <body>
    <?php
        include 'reqs/menu.php';
    ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!--add node form-->
                    <form class="form-horizontal" method="POST" action="">
                        <fieldset>
                            <legend><?php if(isset($_GET['update'])) {echo "Update Sensor";} else {echo "Create Sensors";}?></legend>
                            
                            <div class="form-group">
                                <label for="sensor_type" class="col-sm-4 control-label">Sensor type</label>
                                <div class="col-sm-8">
                                    <select id="sensor_type" name="sensor_type" class="form-control">
                                        <option value="pressure" <?php if(isset($_GET['update']) && $u_sensor->getType()=="pressure"){echo 'selected';} ?>>Pressure</option>
                                        <option value="humidity" <?php if(isset($_GET['update']) && $u_sensor->getType()=="humidity"){echo 'selected';} ?>>Humidity</option>
                                        <option value="temperature" <?php if(isset($_GET['update']) && $u_sensor->getType()=="temperature"){echo 'selected';} ?>>Temperature</option>
                                    </select>  
                                </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="node_id" class="col-sm-4 control-label">Node</label>
                              <div class="col-sm-8">
                                  <select class="form-control" id="node_id" placeholder="Hanthana" name="node_id">
                                      <?php                                        
                                        foreach ($nodes as $node)
                                        {
                                            if($_GET['update'])
                                            {
                                                if($node->getNodeId()==$u_node->getNodeId())
                                                {
                                                    echo '<option value='. $node->getNodeId() .' selected>'.$node->getName().'</option>';
                                                }
                                                else
                                                    echo '<option value='. $node->getNodeId() .'>'.$node->getName().'</option>';
                                            }
                                            else
                                                echo '<option value='. $node->getNodeId() .'>'.$node->getName().'</option>';
                                        }
                                      ?>
                                  </select>
                              </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-4 col-sm-8">
                                    <?php
                                        if(isset($_GET['update']))
                                        {
                                    ?>
                                            <button type="submit" name="update" value="update_sensor" class="btn btn-success">Update</button>
                                    <?php
                                        }
                                        else
                                        {
                                    ?>
                                        <button type="submit" name="submit" value="add_sensor" class="btn btn-success">Add</button>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        
                        </fieldset>
                      </form>
                    </div>
                </div>
                <div class="col-lg-8">&nbsp;</div>
            </div>
        </div>
        
    <?php
        include 'reqs/foot.php';
    ?>
    </body>
</html>
