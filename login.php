<?php
    require_once 'lib/init.php';
    if($user->loggedIn())
    {
        header("location: profile.php");
    }

    if(isset($_POST['login']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if($_SESSION['id']=$user->login($username, $password))
        {            
            header("location:profile.php");
        }
        else
        {
            header("location:login.php?login_error");
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php
            include 'reqs/head.php';
        ?>
        <title>Login to WeatherCenter</title>
    </head>
    <body>
        <?php
            include 'reqs/menu.php';
        ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">          
                    <?php
                        if(isset($_GET['login_error']))
                        {
                    ?>
                        <div class="alert alert-warning">
                            Your <strong>username</strong> or <strong>password</strong> is not correct, please correct them and re-try.
                        </div>
                    <?php
                        }
                    ?>
                    <form class="form-horizontal content" action='' method="POST">
                        <fieldset>
                          <div id="legend">
                            <legend class="">Login</legend>
                          </div>
                          <div class="control-group">
                            <!-- Username -->
                            <label class="control-label"  for="username">Username</label>
                            <div class="controls">
                                <input type="text" id="username" name="username" placeholder="JohnD" class="input-xlarge" required>
                              <p class="help-block">Username can contain any letters or numbers, without spaces</p>
                            </div>
                          </div>

                          <div class="control-group">
                            <!-- Password-->
                            <label class="control-label" for="password">Password</label>
                            <div class="controls">
                                <input type="password" id="password" name="password" placeholder="password" class="input-xlarge" required>
                              <p class="help-block">Password should be at least 4 characters</p>
                            </div>
                          </div>

                          <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                                <button type="submit" class="btn btn-success" name="login">Login</button>
                            </div>
                          </div>
                        </fieldset>
                    </form>  
                </div>
                <div class="col-lg-6">
                    <br>
                    
                    <h4>To register <a href="register.php">goto registration </a>page</h4>
                    
                </div>
            </div>
        </div>
        <?php
        include 'reqs/foot.php';
    ?>
    </body>
</html>
