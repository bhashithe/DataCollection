<?php
    require 'lib/init.php';
    
    if(isset($_GET['id']))
    {
        $node_id = $_GET['id'];
        
        if(!Node::isNode($node_id))
        {
            if($user->loggedIn())
                header("location: add_node.php");
            else
                header("location: index.php");
                
        }
        $node = new Node($node_id);
        
        $sensors = $node->getSensors();
        
        $owner = new User($node->getOwnerId());
        
        if(isset($_POST['delete']) && $_POST['delete'] = "Delete")
        {
            $user->deleteSensor($node,$_POST['sensor_id']);
            header("location: node_data.php?id=".$_GET['id']);
        }
        
        if(isset($_POST['delete_node']) && $_POST['delete_node']=="Delete")
        {
            $node_id = htmlentities($_POST['node_id']);
            $user->deleteNode($node_id);
            header("location: profile.php");
        }
        
        if(isset($_POST['toggle']) && $_POST['toggle']=="Toggle")
        {
            $user->toggleSensor($node,$_POST['sensor_id']);
            header("location: node_data.php?id=".$_GET['id']);
        }
        
        if(isset($_POST['update']) && $_POST['update']=="Update")
        {
            header("location: add_sensor.php?update=".$_POST['sensor_id']);
        }
    }
    else
    {
        header("location: profile.php");
    }
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Node Details | WeatherCenter</title>
        <?php
            include 'reqs/head.php';
        ?>
        <script>
            $(document).ready();
        </script>
    </head>
    <body>
        <?php
            include 'reqs/menu.php';
        ?>
        <div class="container">
            <div class="row profile">
                        <div class="col-md-3">
                                <div class="profile-sidebar">
                                        <!-- SIDEBAR USERPIC -->
                                        <div class="profile-userpic">
                                            <img src="img/avatar/defaultm.png" class="img-responsive" alt="<?php echo $owner->getUsername(); ?>">
                                        </div>
                                        <!-- END SIDEBAR USERPIC -->
                                        <!-- SIDEBAR USER TITLE -->
                                        <div class="profile-usertitle">
                                                <div class="profile-usertitle-name">
                                                        <?php echo $owner->getUsername(); ?>
                                                </div>
                                                <div class="profile-usertitle-job">
                                                        <?php if($owner->isAdmin()){echo 'Admin';} else {echo "DataCollector";} ?>
                                                </div>
                                        </div>
                                        <!-- END SIDEBAR USER TITLE -->
                                        <!-- SIDEBAR BUTTONS -->
                                        <div class="profile-userbuttons">
                                            <?php
                                                if($user->loggedIn() && $user==$owner) //checks if logged in user is the owner
                                                {
                                            ?>
                                                    <a href="add_sensor.php" class="btn btn-success btn-sm">Add Sensor</a>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <!-- END SIDEBAR BUTTONS -->
                                </div>
                        </div>
                        <div class="col-md-9">
                            <div class="profile-content">
                                <h3 align="center"><span class="center-block"><?php echo $node->getName(); ?></span></h3>
                                <?php if($owner==$user || $user->isAdmin()){?><p class="device-id" title="Device ID"><?php echo $node->getUniqStr(); ?></p><?php }?>
                                <br>
                                <?php
                                    if($user->isAdmin())
                                    {
                                ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="node_id" value="<?php echo $node->getNodeId(); ?>">
                                    <input class="btn-xs btn-danger pull-right" type="submit" name="delete_node" value="Delete" Title="deletes this node" >
                                </form>
                                <?php
                                    }
                                ?>
                                <br>
                                <table class="table table-hover">
                                    <?php
                                        if($node->hasSensors())
                                        {
                                            echo '<tr><th>Unique Id</th><th>Sensor Type</th><th>Last Read</th><th>Options</th></tr>';
                                            foreach ($sensors as $sensor) 
                                            {
                                        ?>
                                        <tr>
                                            <td><?php echo $sensor->getSensorId(); ?></td>
                                            <td><?php echo $sensor->getType(); ?></td>
                                            <td><?php echo $sensor->getLastRead(); ?></td>
                                            <td><form action="" method="POST"><input type="button" class="btn-xs btn-info" onclick="location.href='sensor_data.php?id=<?php echo $sensor->getSensorId(); ?>'" value="View"> <?php if($owner==$user || $user->isAdmin()){?><input class="btn-xs <?php if($sensor->getActivated()) echo 'btn-warning'; else echo 'btn-primary'; ?>" type="submit" value="Toggle" name="toggle"> <input class="btn-xs btn-success" type="submit" value="Update" name="update"> <input class="btn-xs btn-danger" type="submit" value="Delete" name="delete"><input type="hidden" value="<?php echo $sensor->getSensorId(); ?>" name="sensor_id"><?php } ?></form></td>
                                        </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                </div>
        </div>
        <?php
            include 'reqs/foot.php';
        ?>
    </body>
</html>
