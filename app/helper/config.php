<?php
$servername = "localhost";
$username = "root";
$password = "";

$DBConnect = mysqli_connect($servername, $username, $password);

if (!$DBConnect) {
    die("Connection failed: " . mysqli_connect_error());
}
$shop_DB = mysqli_select_db($DBConnect, "shopVNB");
if (!shop_DB) {
    die("Database selection failed: " . mysqli_error($DBConnect));
}
?>