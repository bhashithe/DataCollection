<?php 
    include 'lib/init.php';
    $node_ids = null;
    
    $rand = array('#1abc9c', '#f39c12', '#95a5a6', '#3498db', '#34495e', '#c0392b', '#bdc3c7', '#d35400', '#16a085', '#2c3e50');
    $color = $rand[rand(0,9)];
    
    if(isset($_GET['all']))
    {
        $node_ids = $general->getAllNodes(); 
    }
    else
    {
        $node_ids = $general->getRandomNodes();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head> 
    <?php
        include 'reqs/head.php';
    ?>
    <title>Weather Center - The Data Collection Project</title>
</head>

<body>

   <?php
    include 'reqs/menu.php';
   ?>
    <div class="intro-header">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-message">
                        <h1>Weather Center</h1>
                        <h3>An open source data collection project</h3>
                        <hr class="intro-divider">
                        <ul class="list-inline intro-social-buttons">
                            <li>
                                <a href="https://twitter.com/weather_lka" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                            </li>
                            <li>
                                <a href="https://github.com/bhashithe/weather_lka" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                            </li>
                            <li>
                                <a href="#" class="btn btn-default btn-lg"><i class="fa fa-facebook fa-fw"></i> <span class="network-name">Facebook</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>
                <?php 
                    if(isset($_GET['all']))
                    {
                        echo "All nodes in WeatherCenter";
                    }
                    else
                    {
                        echo "Nodes in WeatherCenter";
                    }
                    
                ?>
                </h3>
                <?php
                   foreach ($node_ids as $node_id)
                   {
                       $node = new Node($node_id['node_id']);
                       $owner = new User($node->getOwnerId());
                ?>
              <div class="col-md-3">
                <div class="productbox">
                    <div class="img-responsive" style="background-color: <?php echo $rand[rand(0,9)]; ?>">&nbsp;</div>
                    <div class="producttitle"><?php echo $node->getName(); ?></div>
                    <p class="text-justify"><?php echo count($node->getActiveSensors()).'/'.$node->getSensorCount();?></p>
                    <div class="productprice"><div class="pull-right"><a href="node_data.php?id=<?php echo $node->getNodeId(); ?>" class="btn btn-primary btm-sm" role="button">View</a></div><div class="pricetext"><?php echo $owner->getUsername(); ?></div></div>
                </div>
              </div>
                <?php
                   }
                ?>
            </div>
        </div>
    </div>
    
    <br>
    <br>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-1">
                <a class="btn btn-sm btn-success" href="index.php?all">All Sensors</a>
            </div>
        </div>
    </div>


    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-inline">
                        <li>
                            <a href="#">Home</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#services">Services</a>
                        </li>
                            <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="#contact">Contact</a>
                        </li>
                    </ul>
                    <p class="copyright text-muted small">stealing ideas is bad, improve them</p>
                </div>
            </div>
        </div>
    </footer>
    
    <?php
        include 'reqs/foot.php';
    ?>
</body>

</html>
