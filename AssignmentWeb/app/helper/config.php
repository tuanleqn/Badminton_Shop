<?php
class db
{
    public $connect;
    protected $servername = "localhost";
    protected $username = "root";
    protected $password = "123456";
    protected $dbname = "shopVNB";

    function __construct()
    {
        // Enable error reporting for mysqli
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            // Connect to MySQL
            $this->connect = mysqli_connect($this->servername, $this->username, $this->password);
            if (!$this->connect) {
                throw new Exception("Connection failed: " . mysqli_connect_error());
            }

            // Select database
            if (!mysqli_select_db($this->connect, $this->dbname)) {
                throw new Exception("Cannot select database: " . mysqli_error($this->connect));
            }

            // Set charset
            if (!mysqli_set_charset($this->connect, "utf8")) {
                throw new Exception("Error setting charset: " . mysqli_error($this->connect));
            }

            // Set timezone
            mysqli_query($this->connect, "SET time_zone = '+07:00'");

        } catch (Exception $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    function __destruct()
    {
        if ($this->connect) {
            mysqli_close($this->connect);
        }
    }
}

// Create a single instance of the database connection
$db = new db();
$DBConnect = $db->connect;
?>