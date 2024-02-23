<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: PUT");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type, 
Acess-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true);

$pid = $data["ID"];
$pname = $data["username"];
$ppassword = $data["password"];

 include('servercon.php');

echo $query = "UPDATE tbluser SET username= '".$pname."' , 
                                 password= '".$ppassword."' 
                           WHERE ID ='".$pid."' ";

if(mysqli_query($dbconnect, $query) or die("Update Query Failed"))
{	
	echo json_encode(array("message" => "Update Successfully", "status" => true));	
}
else
{	
	echo json_encode(array("message" => "Failed", "status" => false));	
}

?>