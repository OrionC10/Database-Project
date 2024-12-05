<?php
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    // error_log("connection suck");
    die("Connection failed: " . $conn->connect_error);
}
?>
