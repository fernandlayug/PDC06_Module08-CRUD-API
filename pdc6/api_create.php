<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST");
// header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type, 
// Acess-Control-Allow-Methods, Authorization");


$data = json_decode(file_get_contents("php://input"), true);

$pname = $data["username"];
$ppassword = $data["password"];

include('servercon.php');
$query = "INSERT INTO tbluser(username, password) 
                       VALUES ('".$pname."', '".$ppassword."')";

if(mysqli_query($dbconnect, $query) or die("Insert Query Failed"))
{
	echo json_encode(array("message" => "Inserted Successfully", "status" => true));	
}
else
{
	echo json_encode(array("message" => "Not Inserted ", "status" => false));	
}

?>