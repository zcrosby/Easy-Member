<?php

class Admin extends DatabaseClass {
    
    public function authenticateUser(){
        //check that the user is logged in with session
        
        if( isset($_SESSION['isLoggedIn']) && $_SESSION["isLoggedIn"] == true){
            return true;
        }
        else{
            echo "access not granted";
            $this->redirectToLogin();
        }
    }
    
    public function displayCurrentInfo(){
        /*when a new user is directed to their admin page from the initial sign up,
        the dummy data should be displayed*/
        //set ussr id == to the UseID from $_SESSION
        $userID = $_SESSION['UserID'];
       //debug var_dump($userID);
        $result = array();
        
       $db = $this->connectToDB();
       try {
            //debug var_dump($db);
            if( NULL != $db ){
                $stmt = $db->prepare('select * from page where user_id = :userID limit 1');
                $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                //debug var_dump($result);

                if( $stmt->execute() ){
                    //a check to make sure that actual values are returned, if they are, the user exists
                    //and their login is valid.
                    if ( is_array($result) && count($result) ) {
                        //var_dump($result);
                        return $result;
                        $this->closeDB();
                    }
                }//end $stmt execute
            }//end $db!= null 
       }//end try
       catch (Exception $ex) {
           //when you null a PDO object is automatically closes the connection to the database.
           //debug var_dump($ex);
           echo "Error!: " . $ex->getMessage() . "<br/>"; 
           $this->closeDB();
       }
        
    }
    
    public function updateAdminPageInfo(){
        //the page table in db is for info on admin page
        //use an updte statement to update the info in db
        $title = filter_input(INPUT_POST, 'title');
        $theme = filter_input(INPUT_POST, 'theme');
        $address = filter_input(INPUT_POST, 'address');
        $phone = filter_input(INPUT_POST, 'phone');
        $email = filter_input(INPUT_POST, 'email');
        $about = filter_input(INPUT_POST, 'about');
        $userID = $_SESSION['UserID'];
        $result = array();
        
       $db = $this->connectToDB();
       try {
            //debug var_dump($db);
            if( NULL != $db ){
                $stmt = $db->prepare('update page set title = :title, theme = :theme, address = :address, phone = :phone, email = :email, about = :about where user_id = :userID');
                $stmt->bindParam(':title', $title, PDO::PARAM_STR);
                $stmt->bindParam(':theme', $theme, PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':about', $about, PDO::PARAM_STR);
                $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
                $stmt->execute();

                if( $stmt->execute() ){
                    //a check to make sure that actual values are returned, if they are, the user exists
                    //and their login is valid.
                    
                    //var_dump($result);
                    $this->closeDB();
                    return true; 
                }//end $stmt execute
            }//end $db!= null 
       }//end try
       catch (Exception $ex) {
           //when you null a PDO object is automatically closes the connection to the database.
           //debug var_dump($ex);
           echo "Error!: " . $ex->getMessage() . "<br/>"; 
           $this->db = null;
       }
       return false;  
    }//end Update

/*UTILITY*/
    public function redirectToLogin(){
        header("Location: login.php"); 
        exit();  
    } //end redirectToLogin()
    
    public function refreshPage(){
        header("Location: admin.php"); 
        exit();  
    } //end refreshPage()
   
    
}//end admin class
