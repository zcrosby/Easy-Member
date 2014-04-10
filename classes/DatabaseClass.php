<?php
/**
 * Description of DatabaseClass
 *
 * @author 001252290
 */
class DatabaseClass {
    //protect the variable, so when you create a new instance of this class. this variable is private.
    //unless you extend the DB class then this variable becomes public from within that new inheritance.
    protected $db = null;

    public function connectToDB() {        
        try {
            //$this referes to the DB class, who calls the db method. think of it like this.db = new PDO(connection to db);
            $this->db = new PDO(Config::DB_DNS, Config::DB_USER, Config::DB_PASSWORD);
        } catch (Exception $ex) {
            //when you null a PDO object is automatically closes the connection to the database.
           $this->db = null;
        }
        return $this->db;        
    }
    
     public function closeDB() {        
        $this->db = null;        
    }
        
}

