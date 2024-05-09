<?php
session_start();
include("database.php");


// Initialize error message variable
$error_message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];
    $rememberMe = isset($_POST["rememberMe"]) ? 1 : 0;

    // Check if the email and password match in the database
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful
        // Set remember me cookie if checked
        if ($rememberMe) {
            // Set a cookie to remember the user
            setcookie("remember_user", $username, time() + (4 * 24 * 60 * 60), "/"); // Cookie expires in 4 days
        }

        // Redirect to homepage
        $_SESSION["username"] = $username; // Store username in session variable
        header("Location: https://stackoverflow.com/");
        exit;
    } else {
        // Login failed
        $error_message = "Invalid email or password";
    }
}
?>
