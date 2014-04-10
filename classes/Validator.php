<?php

class Validator {
    
    public static function emailIsValid( $email ) {
       if ( is_string($email) && !empty($email) && preg_match("/[A-Za-z0-9_]{2,}+@[A-Za-z0-9_]{2,}+\.[A-Za-z0-9_]{2,}/", $email) != 0 ) {
           return true;
       }        
       return false; 
    }

    public static function websiteIsValid( $website ) {
       if ( is_string($website) && !empty($website) ) {
           return true;
       }        
       return false; 
    }

    public static function passwordIsValid( $password ) {
       if ( is_string($password) && !empty($password) ) {
           return true;
       }        
       return false; 
    }
    
    
    
}
