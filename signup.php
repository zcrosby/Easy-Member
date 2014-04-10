<?php include 'dependency.php'; ?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>New Member</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body>
        <?php
            //process sign up
            $entryErrors = array();
            $signUpIsSuccessful = false;
            
            if( count($_POST) ){
                $signUp = new SignUp();
                 
                if( $signUp->entryIsValid() && $signUp->userIsNotTaken() ){
                   
                    if( $signUp->processSignUp() ){
                        header("Location: login.php");
                    }
                    else{
                        //echo '<p class="success">', $entryErrors["database"],'</p>';
                    }
                }
                else{
                    $entryErrors = $signUp->getErrors();
                }
            }

       ?>

        <div id="wrapper">
            <div class="header">
                <h1>New Member Registration</h1>
            </div>
            
            <div id="signup_form">
                <form name="signUpForm" action="signup.php" method="post">
                    <label>Website Name:</label> <input type="text" name="website" placeholder="Enter your website name"/> <br />
                        <?php
                        //error check for the website  
                            if(!empty($entryErrors["website"])){
                                echo '<p class="errors">', $entryErrors["website"],'</p>';
                            }
                            if(!empty($entryErrors["websiteTaken"])){
                                echo '<p class="errors">', $entryErrors["websiteTaken"],'</p>';
                            }
                        ?>
                    
                    <label>Email:</label><input type="text" name="email" placeholder="Enter your email"/> <br />
                        <?php
                        //error check for the email 
                            if(!empty($entryErrors["email"])){
                                echo '<p class="errors">'.$entryErrors["email"].'</p>';
                            }
                            if(!empty($entryErrors["emailTaken"])){
                                echo '<p class="errors">'.$entryErrors["emailTaken"].'</p>';
                            }
                        ?>
                    
                    <label>Password:</label><input type="password" name="password" placeholder="Enter your password"/> <br />
                        <?php
                        //error check for the password 
                            if(!empty($entryErrors["password"])){
                                echo '<p class="errors">', $entryErrors["password"],'</p>';
                            }
                        ?>
                    <!--Submit btn -->
                    <input class="button" type="submit" value="Submit" />
                </form>
                <p class="re-route">
                    Already a member? <a href="login.php">Login Here</a>
                </p>
            </div>
        </div><!--End Wrapper-->
    </body>
</html>
