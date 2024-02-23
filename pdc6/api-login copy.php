<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Directly get the username and password parameters from the request
$username = $_GET['username'] ?? '';
$password = $_GET['password'] ?? '';

// Check if both username and password are provided
if (!empty($username) && !empty($password)) {
    include('servercon.php');

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM tbluser WHERE username = ?";
    $stmt = mysqli_prepare($dbconnect, $query);

    // Check if the statement was prepared successfully
    if ($stmt) {
        // Bind the parameter
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result set
        $result = mysqli_stmt_get_result($stmt);

        // Fetch the first row as an associative array
        $user = mysqli_fetch_assoc($result);

        // Close the statement
        mysqli_stmt_close($stmt);

        // Close the database connection
        mysqli_close($dbconnect);

        if ($user) {
            // Verify the plain text password
            if ($password === $user['password']) {
                // Valid credentials, send a success response
                echo json_encode(array("status" => true, "message" => "Login successful", "user" => $user));
            } else {
                // Invalid password, send an error response
                echo json_encode(array("status" => false, "message" => "Invalid password."));
            }
        } else {
            // Invalid username, send an error response
            echo json_encode(array("status" => false, "message" => "Invalid username."));
        }
    } else {
        // Close the database connection
        mysqli_close($dbconnect);

        // Send an error response
        echo json_encode(array("status" => false, "message" => "Error preparing SQL statement."));
    }
} else {
    // Send an error response if username or password is not provided
    echo json_encode(array("status" => false, "message" => "Username or password not provided."));
}
?>
