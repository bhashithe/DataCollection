<?php
    require 'lib/init.php';
    if(!$user->loggedIn())
    {
        header("location: login.php");
    }
    if(isset($_POST['delete']) && $_POST['delete']=="Delete")
    {
        $node_id = htmlentities($_POST['node_id']);
        $user->deleteNode($node_id);
    }    
    
    if(isset($_POST['resend']) && $_POST['resend']=="Resend")
    {
        //code to send activation
    }
    
    if ($user->hasNodes()) 
    {
        $my_nodes = $user->getNodes();
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php
            include 'reqs/head.php';
        ?>
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
                                            <a href="profile.php"><img src="img/avatar/defaultm.png" class="img-responsive" alt="<?php echo $user->getUsername(); ?>"></a>
                                        </div>
                                        <!-- END SIDEBAR USERPIC -->
                                        <!-- SIDEBAR USER TITLE -->
                                        <div class="profile-usertitle">
                                                <div class="profile-usertitle-name">
                                                        <?php echo $user->getUsername(); ?>
                                                </div>
                                                <div class="profile-usertitle-job">
                                                        <?php if($user->isAdmin()){echo 'Admin';} else {echo "DataCollector";} ?>
                                                </div>
                                        </div>
                                        <!-- END SIDEBAR USER TITLE -->
                                        <!-- SIDEBAR BUTTONS -->
                                        <div class="profile-userbuttons">
                                            <?php
                                                if($user->loggedIn())
                                                {
                                            ?>
                                            <a href="add_node.php" class="btn btn-success btn-sm">Add Nodes</a>
                                            <?php
                                                }
                                            ?>
                                        </div>
                                        <!-- END SIDEBAR BUTTONS -->
                                        <!-- SIDEBAR MENU -->
                                        <div class="profile-usermenu">
<!--                                                <ul class="nav">
                                                        <li class="active">
                                                                <a href="#">
                                                                <i class="glyphicon glyphicon-home"></i>
                                                                Overview </a>
                                                        </li>
                                                        <li>
                                                                <a href="#">
                                                                <i class="glyphicon glyphicon-user"></i>
                                                                Account Settings </a>
                                                        </li>
                                                        <li>
                                                                <a href="#" target="_blank">
                                                                <i class="glyphicon glyphicon-ok"></i>
                                                                Tasks </a>
                                                        </li>
                                                        <li>
                                                                <a href="#">
                                                                <i class="glyphicon glyphicon-flag"></i>
                                                                Help </a>
                                                        </li>
                                                </ul>-->
                                        </div>
                                        <!-- END MENU -->
                                </div>
                        </div>
                        <div class="col-md-9">
                            <div class="profile-content">
                                    <?php
                                        if(isset($_GET['not_confirmed']))
                                        {
                                    ?>
                                        <div class="alert alert-warning">
                                            <form method="POST" action="">
                                                You have to confirm your e-mail address to continue <input class="btn" type="submit" name="resend" value="Resend">
                                            </form>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        if(isset($_GET['not_confirmed_no_nodes']))
                                        {
                                    ?>
                                        <div class="alert alert-warning">
                                            <form method="POST" action="">
                                                You have to confirm your e-mail address or you need to create nodes to continue <input class="btn" type="submit" name="resend" value="Resend">
                                            </form>
                                        </div>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                    if($user->hasNodes())
                                    {  
                                    ?>
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Node name</th>
                                            <th>Number of Sensors</th>
                                            <th>Options</th>
                                        </tr>
                                    <?php
                                        foreach ($my_nodes as $node) 
                                        {
                                    ?>
                                        <tr>
                                            <td>
                                                    <?php echo $node->getName(); ?>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $node->getSensorCount();
                                                ?>
                                            </td>
                                            <td>                                                
                                                <form method="POST" action="">
                                                    <input type="button" class="btn-xs btn-info" onclick="location.href='node_data.php?id=<?php echo $node->getNodeId(); ?>'" value="View">
                                                    <input type="hidden" name="node_id" value="<?php echo $node->getNodeId(); ?>">
                                                    <input class="btn-xs btn-danger right" type="submit" name="delete" value="Delete">  
                                                </form>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    ?>
                                    </table>
                                    <?php
                                    }
                                    ?>                                
                            </div>
                        </div>
                </div>
        </div>
        <?php
        include 'reqs/foot.php';
    ?>
    </body>
</html>
