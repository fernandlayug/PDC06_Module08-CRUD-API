<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Directly get the username parameter from the request
$username = $_GET['username'] ?? '';

// Check if username is not empty
if (!empty($username)) {
    include('servercon.php');

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM tbluser WHERE username LIKE ?";
    $stmt = mysqli_prepare($dbconnect, $query);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result set
        $result = mysqli_stmt_get_result($stmt);

        // Fetch all rows as an associative array
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Close the statement
        mysqli_stmt_close($stmt);

        // Close the database connection
        mysqli_close($dbconnect);

        // Send the response
        echo json_encode(array("status" => true, "data" => $rows));
    } else {
        // Close the database connection
        mysqli_close($dbconnect);

        // Send an error response
        echo json_encode(array("status" => false, "message" => "Error preparing SQL statement."));
    }
} else {
    // Send an error response
    echo json_encode(array("status" => false, "message" => "Email not provided."));
}
?>
