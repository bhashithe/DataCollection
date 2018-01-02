<?php
    require 'lib/init.php';
    $node = null;
    $sensor = null;
    $data = NULL;
    if(isset($_GET['id']))
    {
        $sensor_id = $_GET['id'];
        if(!Sensor::isSensor($sensor_id))
        {
            if($user->loggedIn())
                header("location: add_sensor.php");
            else
                header("location: index.php");
                
        }
        $sensor_factory = new SensorFactory(); 
        $sensor_type = Sensor::getSensorTypeForId($sensor_id);
        $sensor = $sensor_factory->getSensorObjectWithId($sensor_type, $sensor_id);
        
        $node = new Node($sensor->getNodeId());
        $owner = new User($node->getOwnerId());
        
        $data = $sensor->getData();
        
        if( isset($_POST['submit']) && $_POST['submit']=="submit")
        {
            $from = htmlentities($_POST['from']);
            $to = htmlentities($_POST['to']);
            $time_range = array("from"=>$from, "to"=> $to);
            
            $result = $data->getValueWithTime($time_range);
            
            $user->exportCsv($result);
        }
        
        if(isset($_POST['delete_data']) && $_POST['delete_data']=="Delete")
        {
            $from = htmlentities($_POST['from']);
            $to = htmlentities($_POST['to']);
            $time_range = array("from"=>$from, "to"=> $to);
            
            $user->deleteData($sensor->getSensorId(),$time_range);
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
        <title>Sensor Details | WeatherCenter</title>
        <?php
            include 'reqs/head.php';
        ?>
        <script type="text/javascript" src="js/jsapi"></script>
        <script type="text/javascript">
          google.load('visualization', '1.1', {packages: ['line']});
          google.setOnLoadCallback(drawChart);

          function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('datetime', 'Timestamp');
            data.addColumn('number', '<?php echo $sensor->getType(); ?>');

            data.addRows([
                <?php
                    $values = $data->getValue();
                    $len=  count($values);
                    $i=0;
                    foreach($values as $value)
                    {
                        $date  =  new DateTime($value['time_stamp']);
                        if($i==$len-1)
                            echo '[new Date(\''.$value['time_stamp'] .'\'),'.$value['reading'].']';
                        else
                            echo '[new Date(\''.$value['time_stamp'] .'\'),'.$value['reading'].'],';
                        
                        $i++;
                    }
                ?>
            ]);

            var options = {
                            chart: {
                              title: '<?php echo $node->getName(); ?>',
                              subtitle: 'Unit - <?php echo $sensor->getData()->getUnit(); ?>',
                              pointSize: 30
                            },
                            width: 800,
                            height: 300,
                            vAxis: {format:'decimal'},
                            pointSize: 30,
                          };
            
            var chart = new google.charts.Line(document.getElementById('line_top_x'));
            var formatter = new google.visualization.NumberFormat({pattern:'0.0e00'});
            formatter.format(data, 1);

            chart.draw(data, google.charts.Line.convertOptions(options));
          }
        </script>
        <script type="text/javascript" src="js/moment.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css" />
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
                                <h3 align="center"><?php echo $node->getName(); ?></h3>
                                <p class="profile-usertitle-job centrize"><?php echo $sensor->getType(); ?></p>
                                                   

                                <div id="line_top_x"></div>
                                
                                <br>
                                <br>
                                <?php
                                    if($user->loggedIn())
                                    {
                                ?>
                                <form action="" method="POST" class="form-horizontal">
                                    <fieldset>
                                        <div id="legend">
                                          <legend class="">Download CSV file</legend>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class='input-group date' id='datetimepicker6'>
                                                        <input type='text' class="form-control" name="from"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class='input-group date' id='datetimepicker7'>
                                                        <input type='text' class="form-control" name="to"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-md-2">
                                                <div class="control-group">
                                                    <!-- to -->
                                                    <div class="controls">
                                                        <input type="submit" name="submit" value="submit" class="btn btn-sm btn-success">
                                                    </div>  
                                                </div>  
                                            </div>
                                        </div>                                        
                                        
                                    </fieldset>
                                </form>
                                <?php
                                    }
                                    else
                                    {
                                        echo '<b><a href="login.php">log in</a> to download CSV files.';
                                    }
                                ?>
                                
                                <?php
                                    if($user->isAdmin())
                                    {
                                ?>
                                <form action="" method="POST" class="form-horizontal">
                                    <fieldset>
                                        <div id="legend">
                                          <legend class="">Delete data</legend>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class='input-group date' id='datetimepicker6'>
                                                        <input type='text' class="form-control" name="from"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <div class='input-group date' id='datetimepicker7'>
                                                        <input type='text' class="form-control" name="to"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-md-2">
                                                <div class="control-group">
                                                    <!-- to -->
                                                    <div class="controls">
                                                        <input type="submit" title="delete selected data" name="delete_data" value="Delete" class="btn btn-sm btn-danger">
                                                    </div>  
                                                </div>  
                                            </div>
                                        </div>                                        
                                        
                                    </fieldset>
                                </form>
                                <?php
                                    }
                                ?>
                                
                            </div>
                        </div>
                </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker6').datetimepicker(
                {
                    //use24hours: true,
                    format: 'YYYY-MM-DD HH:mm'
                });
                $('#datetimepicker7').datetimepicker({
                    useCurrent: false, //Important! See issue #1075
                    //use24hours: true,
                    format: 'YYYY-MM-DD HH:mm'
                });
                $("#datetimepicker6").on("dp.change", function (e) {
                    $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepicker7").on("dp.change", function (e) {
                    $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
                });
            });
        </script>
        <?php
            include 'reqs/foot.php';
        ?>
    </body>
</html>
