<?php include 'dependency.php'; ?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Preview</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    </head>
    <body style="background-color: #796466">
        <?php
            $ad = new Admin();
            $rowReturned = $ad->displayCurrentInfo();
        ?>       
        
        <a href="admin.php" >Back</a>
        
        
            <div id="wrapper" >
                <div id="contact">
                    <h3>Contact</h3>
                    <ul id="titles">
                        <li>Title</li>
                        <li>Address</li>
                        <li>Phone</li>
                        <li>Email</li>
                    </ul>
                    <ul>
                        <li><?php echo $rowReturned["title"]; ?></li>
                        <li><?php echo $rowReturned["address"]; ?></li>
                        <li><?php echo $rowReturned["phone"]; ?></li>
                        <li><?php echo $rowReturned["email"]; ?></li>
                    </ul>
                </div>

                <div id="about">
                    <h3> About Me</h3>
                    <p>
                        <?php echo $rowReturned["about"]; ?>
                    </p>
                </div>

            </div>
        
        <script src="js/scripts.js"> </script>
    </body>

</html>
