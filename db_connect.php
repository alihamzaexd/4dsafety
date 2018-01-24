<?php

/**
 * A class file to connect to database
 */
class DB_CONNECT {

    // constructor
    function __construct() {
        // connecting to database
       // $this->connect();
    }

    /** 
     * Function to connect with database
     */
    function connect() {
        // import database connection variables
        //require_once __DIR__ . '/db_con.php';

        $host = "localhost"; // db ip
        $user = "postgres"; // db username (mention your db password here)
		$pass = "exd@123456";// database password
        $db = "4dsafety"; // db 
        // Connecting to my database 
	$con = pg_connect("host=$host dbname=$db user=$user password=$pass") or die ("Could not connect to server\n"); 

        
	    // returing connection cursor
        return $con;
    }

    function close($con) {
        // closing db connection
		pg_close($con);
    }


}

?>
