<?php

class SignUp extends DatabaseClass {
    
    protected $errors = array();
    
    public function processSignUp(){
        //check if info is valid(!dirty data)
        
        if( count($_POST) ){
            $website = filter_input(INPUT_POST, 'website');
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST, 'password');
            $password = sha1($password);

            if( $this->insertNewUser($website,$email, $password)){
                return true;
            }
            else{
                $this->errors["database"] = "Database error, please try again.";
                return false;
            }
        }
    }//end processSignUp
    
    public function insertNewUser($website, $email, $password){
            $db = $this->connectToDB();
            $password = sha1($password);
 
            if ( null != $db ) {
                $stmt = $db->prepare('insert into users set email = :email, website = :website, password = :password');
                $stmt->bindParam(':website', $website, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                             
                if( $stmt->execute() ){  
                    if ( $this->insertDefaultData() ){
                        $this->closeDB();
                        return true;
                }
            }
            return false;
        }
    }//endinsertNewUser
    
    public function insertDefaultData(){
        //this should happen for every new sign up
        /*dummy data that can be updated each time the user edits their info on the admin page*/ 
       $userID = $this->findUserID();
       $email = filter_input(INPUT_POST, 'email');
       //debug var_dump($userID);
       $db = $this->connectToDB();

        if ( null != $db ) {  
            $stmt = $db->prepare("insert into page set "
                    . "user_id = :userID,"
                    . "title = 'title',"
                    . "theme = 'theme', "
                    . "address = 'address',"
                    . "phone = 'phone',"
                    . "email = :email,"
                    . "about = 'Add your info';");
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            
            if ( $stmt->execute() ){
                  $this->closeDB();
                  return true;
            }
        }
        return false;
 
    }//end insertDeafaultData
    
    public function findUserID(){
        //goes into db and returns user id
        //set the returned id to the userID in the session
        $website = filter_input(INPUT_POST, 'website');
        $email = filter_input(INPUT_POST, 'email');
        
        $db = $this->connectToDB();
        if( $db != NULL){
            $stmt = $db->prepare('select user_id from users where website = :website and email = :email limit 1');
            $stmt->bindParam(':website', $website, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $rowReturned = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $idNum = intval($rowReturned["user_id"]);
            
            if ( $stmt->execute() ){
                  $this->closeDB();
                  return $idNum;
            }
        }  
    }
    
    
    public function entryIsValid(){
        //simple function that checks that the sigup entries are validated
        $this->websiteEntryIsValid();
        $this->emailEntryIsValid();
        $this->passwordEntryIsValid();

        return (count($this->errors) ? false : true);

    }
  
    public function websiteEntryIsValid(){
        
        if( array_key_exists("website", $_POST) ){
            if( !Validator::passwordIsValid($_POST["website"]) ){
                    $this->errors["website"] = "Website is invalid";                   
            }
        }   
        return (empty($this->errors["website"]) ? true : false);
    }
    
    
    public function emailEntryIsValid(){
        
        if( array_key_exists("email", $_POST) ){
                //we know post is global, so we don't need to pass it in here.
                //if email exists but is not valid (after checking with the validator) 
                //then add the error to the errors array list. is valid remains false.
            if( !Validator::emailIsValid($_POST["email"]) ){
                    $this->errors["email"] = "Email is invalid";                   
            }
        }   
        //if error message is empty, returns false. b/c there is an error
        return (empty($this->errors["email"]) ? true : false);
    }

    
    public function passwordEntryIsValid(){
        
        if( array_key_exists("password", $_POST) ){
            if( !Validator::passwordIsValid($_POST["password"]) ){
                    $this->errors["password"] = "Password is invalid";                   
            }
        }   
        return (empty($this->errors["password"]) ? true : false);
    }
    
     public function getErrors() {
        return $this->errors;
    }
    
            
    public function userIsNotTaken(){
        $website = filter_input(INPUT_POST, 'website');
        $email = filter_input(INPUT_POST, 'email');
        
        if( $this->emailIsTaken($email) ){
            //tell them email is taken, return false
            //maybe put error into an associative array
            $this->errors["emailTaken"] = "Email is already taken"; 
            return false;
        }
        if ( $this->websiteIsTaken($website) ){
            //tell them website name is taken, add it to errors list
            $this->errors["websiteTaken"] = "Website name is already taken"; 
            return false;
        }
        
        return true;
    }//end userInfoAlreadyExists
    
    public function emailIsTaken($email){
        $db = $this->connectToDB();
        if ( null != $db ) {
            $stmt = $db->prepare('select email from users where email = :email limit 1');
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            //the fetch function allows you to get the associated value to the username
            $result = $stmt->fetch(PDO::FETCH_ASSOC); 
            
            //(although, fethc may return other things besides arrays)
            if ( is_array($result) && count($result) ) {
                $this->closeDB();
                return true;
            }
        }
    }
    
    public function websiteIsTaken($website){
        $db = $this->connectToDB();
        if ( null != $db ) {
            $stmt = $db->prepare('select website from users where website = :website limit 1');
            $stmt->bindParam(':website', $website, PDO::PARAM_STR);
            $stmt->execute();
            
            //the fetch function allows you to get the associated value to the username
            $result = $stmt->fetch(PDO::FETCH_ASSOC); 
            
            //if fetch finds something it must be an array and be something within that array. 
            //(fethc may return other things besides arrays)
            if ( is_array($result) && count($result) ) {
                $this->closeDB();
                return true;  
            }
        }
    }
    
    public function hasErrors(){

        return ( count($this->errors) > 0 ? true:false );
    }
     

}
