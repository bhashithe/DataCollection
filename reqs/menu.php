<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
    <div class="container topnav">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand topnav" href="index.php">Weather Center</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#">Downloads</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                    <?php
                        $user = new User();
                        if(!$user->loggedIn())
                        {
                    ?>
                        <li>
                            <a href="login.php">Login</a>
                        </li>
                    <?php
                        }
                        else
                        {
                    ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $user->getUsername();?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li class="dropdown-header">Node Settings</li>
                              <li><a href="add_node.php">Add Nodes</a></li>
                              <li><a href="add_sensor.php">Add Sensors</a></li>
                              <li role="separator" class="divider"></li>
                              <li class="dropdown-header">User Settings</li>
                              <li><a href="profile.php">Profile</a></li>
                              <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php
                        }
                    ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
<div class="nav-clear-fix"></div>