<?php
    require 'lib/init.php';
    
    if($user->loggedIn())
    {
        header("location: profile.php");
    }
    
    if(isset($_POST['register']))
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user->register($username, $password, $email);
        header("location: login.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php
            include 'reqs/head.php';
        ?>
        <title>Register at WeatherCenter</title>
        
        <script type="text/javascript">
            window.onload = function () {
                    document.getElementById("password").onchange = validatePassword;
                    document.getElementById("passwordConfirm").onchange = validatePassword;
            }
            function validatePassword(){
            var pass2=document.getElementById("passwordConfirm").value;
            var pass1=document.getElementById("password").value;
            if(pass1!=pass2)
                    document.getElementById("passwordConfirm").setCustomValidity("Passwords Don't Match");
            else
                    document.getElementById("passwordConfirm").setCustomValidity('');
            }
        </script>
    </head>
    <body>
        <?php
            include 'reqs/menu.php';
        ?>
        <div class="container">
            <div class="row">         
                <div class="col-lg-6">
                    <?php
                        if(isset($_GET['user_exists']))
                        {
                    ?>
                        <div class="alert alert-warning">
                            Your <strong>username</strong> is already taken, please try another one.
                        </div>
                    <?php
                        }
                    ?>
                    
                    <?php
                        if(isset($_GET['email_exists']))
                        {
                    ?>
                        <div class="alert alert-warning">
                            You have already registered with that <strong>e-mail address</strong>, please <a href="login.php">log in</a>
                        </div>
                    <?php
                        }
                    ?>
                    <form class="form-horizontal content" action='' method="POST">
                        <fieldset>
                          <div id="legend">
                            <legend class="">Register</legend>
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
                            <!-- E-mail -->
                            <label class="control-label" for="email">E-mail</label>
                            <div class="controls">
                                <input type="email" id="email" name="email" placeholder="mail@example.com" class="input-xlarge" required>
                              <p class="help-block">Please provide your E-mail</p>
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
                            <!-- Password -->
                            <label class="control-label"  for="passwordConfirm">Password (Confirm)</label>
                            <div class="controls">
                              <input type="password" id="passwordConfirm" name="passwordConfirm" placeholder="confirm password" class="input-xlarge">
                              <p class="help-block">Please confirm password</p>
                            </div>
                          </div>

                          <div class="control-group">
                            <!-- Button -->
                            <div class="controls">
                                <button type="submit" class="btn btn-success" name="register">Register</button>
                            </div>
                          </div>
                        </fieldset>
                    </form>                      
                </div>
                <div class="col-lg-6">
                    <br>
                    
                    <h4>If you are already registered, please <a href="login.php">log in</a></h4>
                    <br>
                    
                    <h3>Terms and Conditions, TL;DR version</h3>
                    <ul>
                        <li>You automatically agree to the T&AMP;C when you are registered</li>
                        <li>Once you upload data to the server, its ours. You can delete your Node or stop sending data, but you can't delete the data you have uploaded.</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <?php
        include 'reqs/foot.php';
    ?>
    </body>
</html>
