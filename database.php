<?php
    $conn = mysqli_connect("localhost", "root", "gh1231234", "stackoverflowlike2");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>