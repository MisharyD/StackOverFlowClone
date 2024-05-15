<?php
    $conn = mysqli_connect("localhost", "root", "", "stackoverflowlike");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>