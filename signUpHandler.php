<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "381-project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error message variable
$error_message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $rememberMe = isset($_POST["rememberMe"]) ? 1 : 0;

    // Check if the username or email already exists in the database
    $sql = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error_message = "Username or email already exists";
    } else {
        // Insert user into the database
        $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            // Set remember me cookie if checked
            if ($rememberMe) {
                // Set a cookie to remember the user
                setcookie("remember_user", $username, time() + (4 * 24 * 60 * 60), "/"); // Cookie expires in 4 days
            }
        
            // Redirect to homepage
            header("Location: https://stackoverflow.com/");
            exit;
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
