<?php
$dbconnect = mysqli_connect("localhost", "testuser","12345678","pdc6");
if(mysqli_connect_errno()){
    echo "Failed to connect to MySql: " . mysqli_connect_error();
    die();
}
?>