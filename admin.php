<?php include 'dependency.php'; ?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body>
        <script language="JavaScript" type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
        <script src="js/scripts.js"> </script>
        <?php
        
            
            $ad = new Admin();
            $grantedAccess = $ad->authenticateUser();
            $userEnteredNewData = count( $_POST );
            
            if( $grantedAccess ){
                $rowReturned = $ad->displayCurrentInfo();
                //debug var_dump($rowReturned);
                
                //if the POST var has entries, then user entered new data. update the DB with new info
                if( $userEnteredNewData ){
                   if($ad->updateAdminPageInfo()){
                      $ad->refreshPage(); 
                   }                  
                }
            }
        
            /*
            $ad = new Admin();
            $ad->displayCurrentInfo();
            */
            
        ?>
        <div id="wrapper">
            <div id="sign-out">
                Are you done? <a href="login.php" >Sign Out</a>
            </div>
                <div class="header">
                    <h1>Edit your page</h1>
                </div>
            
            
            <form id="admin_form" name="adminForm" action="admin.php" method="post">

                <label>Title: </label><input type="text" name="title" value="<?php echo $rowReturned["title"]; ?>" /> <br />
                <label>Theme:</label> <select id="themes" name="theme" > 
                                            <option value="theme1" <?php if($rowReturned["theme"] == "theme1"){echo " selected = 'selected' ";} ?> >Theme 1</option>
                                            <option value="theme2" <?php if($rowReturned["theme"] == "theme2"){echo " selected = 'selected' ";} ?> >Theme 2</option>
                                            <option value="theme3" <?php if($rowReturned["theme"] == "theme3"){echo " selected = 'selected' ";} ?> >Theme 3</option>
                </select><button id="preview-btn" type="button">Preview Profile</button><br />
                <label>Address:</label> <input type="text" name="address" value="<?php echo $rowReturned["address"]; ?>"/> <br />
                <label>Phone:</label> <input type="text" name="phone" value="<?php echo $rowReturned["phone"]; ?>" /> <br />
                <label>Email:</label> <input type="text" name="email" value="<?php echo $rowReturned["email"]; ?>"/> <br />
                <label>About:</label> <textarea name="about"/><?php echo $rowReturned["about"]; ?> </textarea><br />
                          
                <input class="button" type="submit" value="Submit" />  
            </form>
            
        </div>

    </body>
</html>
