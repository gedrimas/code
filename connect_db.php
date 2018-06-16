<?php
Class Db_connection{


    protected static $_instance; 
    public static $linkCon = null;

    public static function getInstance($host, $user, $pass, $dbname){
        if(self::$_instance === null){
            self::$_instance = new self($host, $user, $pass, $dbname);
        }
        return self::$_instance;
    }
    
    private function __construct($host, $user, $pass, $dbname) 
    {
       try {
           self::$linkCon = mysql_connect($host, $user, $pass);
           echo "conection is ok! :)";
           mysql_select_db($dbname);
           echo "<br>db is selected<br>";
       } catch (Exception $e){
           echo $e->getMessage();
       }     
    }
    
    private function __clone(){}
    private function __wakeup(){}   

}           
            
?>

