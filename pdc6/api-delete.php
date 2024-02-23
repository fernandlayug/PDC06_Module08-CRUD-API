<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: DELETE");
//header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers,Content-Type, 
//Acess-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true);

$pid = $data["ID"];

include('servercon.php');

echo $query = "DELETE FROM tbluser WHERE ID='".$pid."' ";

if(mysqli_query($dbconnect, $query) or die("Delete Query Failed"))
{	
	echo json_encode(array("message" => "Product Delete Successfully", "status" => true));	
}
else
{	
	echo json_encode(array("message" => "Failed Product Not Deleted", "status" => false));	
}

?>