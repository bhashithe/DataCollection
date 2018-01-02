<?php
    require 'lib/init.php';
    //url getTest.php?device=UNIQSTRING&SENSOR_ID=VALUE&SENSOR_ID=VALUE...
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Upload data | WeatherCenter</title>
    </head>
    <body>
        <?php
            if(!isset($_GET['device']))
            {
                echo "device not identified";
            }
            else 
            {
                //$factory = new SensorFactory();
                $device_id = $_GET['device'];
                if(Node::checkDeviceValidity($device_id))
                {
                    $node_id = Node::getNodeIdFromDeviceId($device_id);
                    $node = new Node($node_id);
                    $owner = new User($node->getOwnerId());
                    
                    if($node->checkUpload($owner))
                    {                        
                        $sensors = $node->getActiveSensors();

                        foreach ($sensors as $sensor)
                        {
                            if(isset($_GET[$sensor->getSensorId()]))
                                $sensor->performRead($_GET[$sensor->getSensorId()]);
                        }
                        $node->setCurruentUpload();
                        
                        echo "data uploaded to database";
                    }
                    else
                    {
                        echo "last upload was less than 6mins ago, you can try again later";
                    }
                }
                else
                {
                    echo "device is not in the database";
                }
            }
        ?>
    </body>
</html>