<?php
class db {
    public $connect;
    protected $servername = "localhost";
    protected $username = "root";
    protected $password = "";
    protected $dbname = "shopVNB";

    function __construct() {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password);
        if (!$this->connect) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        mysqli_select_db($this->connect, $this->dbname);
        mysqli_query($this->connect, "SET NAMES 'utf8'");
    }
}

// Create a single instance of the database connection
$db = new db();
$DBConnect = $db->connect;
?>