<?php include 'dependency.php'; ?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
    </head>
    <body>
        <?php
            
            //http://localhost/PHP-NEIT/Final/

            $loginIsGood = false;
            
            $_SESSION['isLoggedIn'] = false;
            if( count($_POST) ){
                $lg = new Login();
                $loginIsGood = $lg->processLogin();  
            }
        ?>
        <div id="wrapper">
            <div class="header">
                <h1>Welcome!</h1>
            </div>
            <div id="login_form">
                <form name="loginForm" action="login.php" method="post">
                    <label>Email:</label> <input type="text" name="email" placeholder="Enter your email"/> <br />
                    <label>Password:</label> <input type="password" name="password" placeholder="Enter your password"/> <br />         
                    <input class="button" type="submit" value="Submit" />   
                </form>
                <div class="stay">
                    <?php
                        if($loginIsGood)
                        {
                            echo '<div id="no_account">No login found. Please register for a new account</div>';
                        }
                    ?>
                </div>
                <p>
                    Not a member? <a href="signup.php">Signup Here</a>
                </p>
            </div>
        </div> <!--End Wrapper-->
    </body>
</html>
