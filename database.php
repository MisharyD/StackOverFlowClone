<?php
    $conn = mysqli_connect("localhost", "root", "", "stackoverflowclone");
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>