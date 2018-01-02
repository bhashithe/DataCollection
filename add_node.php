<?php
    require 'lib/init.php';
    if(!$user->loggedIn())
    {
        header("location: login.php");
    }
    if(isset($_POST['submit']) && $_POST['submit']== 'add_node')
    {
        $node_name = htmlentities($_POST['node_name']);
        $node_type = htmlentities($_POST['node_type']);
            $location = htmlentities($_POST['location']);
        $user->addNode($node_name,$node_type,$location);
    }
    
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php
            include 'reqs/head.php';
        ?>
        <title>Create nodes | Weather Center</title>
    </head>
    <body>
    <?php
        include 'reqs/menu.php';
    ?>
        <div class="container">
            <div class="row">
                <br>
                <div class="alert alert-info">
                    <strong>Notice</strong> Please be careful when choosing your names, locations and types of your weather station, you won't be able to change these later.
                </div>
                <div class="col-lg-8">
                    <!--add node form-->
                    <form class="form-horizontal" method="POST" action="">
                        <fieldset>
                            <legend>Create Node</legend>
                            <div class="form-group">
                              <label for="node_name" class="col-sm-4 control-label">Name of the Node</label>
                              <div class="col-sm-8">
                                <input type="node_name" class="form-control" id="node_name" placeholder="Hanthana" name="node_name">
                              </div>
                            </div>
                            <div class="form-group">
                                <label for="node_name" class="col-sm-4 control-label">Node type</label>
                                <div class="col-sm-8">
                                    <select name="node_type" class="form-control">
                                        <option value="weather" selected>Weather Station</option>
                                        <option value="other">Other</option>
                                    </select>  
                                </div>
                            </div>
                            
                            <div class="form-group">
                              <label for="location" class="col-sm-4 control-label">Location</label>
                              <div class="col-sm-8">
                                  <select class="form-control" id="node_name" placeholder="Hanthana" name="location">
                                      <?php
                                        $locations = $general->getLocations();
                                        
                                        foreach ($locations as $location)
                                        {
                                            echo '<option value='. $location['location_id'] .'>'.$location['location_name'].'</option>';
                                        }
                                      ?>
                                  </select>
                              </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-offset-4 col-sm-8">
                                    <button type="submit" name="submit" value="add_node" class="btn btn-success">Add</button>
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
