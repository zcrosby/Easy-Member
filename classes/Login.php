<?php

class Login extends DatabaseClass {
    
    
    public function processLogin(){
        
        /*!! Be sure to encrypt password with sha1 */
         if( count($_POST) ){
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'password');
            $password = sha1($password);
   
            if( $this->userExistsInDB($email, $password) ){
                $_SESSION['isLoggedIn'] = true;
                //$_SESSION['UserID'] = intval( $db->lastInsertId() );
                
                /*!! MAJOR CHANGE here, using lastInsertId instead of your getuserID method*/
                $_SESSION['UserID'] = $this->getUserID($email, $password);
                
                header("Location: admin.php");
                //$this->redirectLoggedInUser();
            }
            else{
                return false;
            }
        }
    }//end processLogin
    
    
    public function userExistsInDB($email, $password){
        //sha1 secures the password 
       $password = sha1($password);
        
       $db = $this->connectToDB();
       try {
            //debug var_dump($db);
            if( NULL != $db ){
                $stmt = $db->prepare('select * from users where email = :email and password = :password limit 1');
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                //debug var_dump($result);

                if( $stmt->execute() ){
                    //a check to make sure that actual values are returned, if they are, the user exists
                    //and their login is valid.
                    if ( is_array($result) && count($result) ) {
                        $this->closeDB();
                        return true;  
                    }
                }//end $stmt execute
            }//end $db!= null 
       }//end try
       catch (Exception $ex) {
           //when you null a PDO object is automatically closes the connection to the database.
           //debug var_dump($ex);
           $this->db = null; 
       }
       
       return false;  
    }//end userExistsInDB
   

    public function getUserID($email, $password){
        //goes into db and returns user id
        //set the returned id to the userID in the session
        $password = sha1($password);
        
        $db = $this->connectToDB();
        if( $db != NULL){
            $stmt = $db->prepare('select user_id from users where email = :email and password = :password limit 1');
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            $rowReturned = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $idNum = intval($rowReturned["user_id"]);
            $this->closeDB();
            return $idNum;
        }
        
    }//end getUserID
    
    
    
/*UTILITY*/
    //perfoms a check to make sure the user authenticated
    public function isLoggedIn(){
        if( isset($_SESSION['isLoggedIn']) && $_SESSION["isLoggedIn"] == true){
            return true;
        }
        return false;
    }//end isLoggedIn
    
    
    public function redirectLoggedInUser(){
        if( $this->isLoggedIn() ){
            header("Location: admin.php");
            exit();
        }
    } //end redirectLoggedInUser
    
    
    public function redirectLoggedOutUser(){
        if( !$this->isLoggedIn() ){
            header("Location: login.php"); 
            exit();
        }
    } //end redirectLoggedOutUser
    
    
}//end Login CLass
