<?php
session_start();

include("database.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!-- line 54 Extra no need for bio -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/userHome.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/home.css">
</head>
<body>
<!-- Header part-->
<?php include ("header.php"); ?>

<!-- Body part-->
<div class="body">
    <div class="container">
        <div class="left-body-container">
            <ul class="tab-container">
                <li class="current-page tab"> <div><img src="images/homeIcon.png" width="20px" height="auto"></div> <div>Home</div> </li>
                <li class="tab"> <img src="images/user.png" width="20px" height="auto"> <div> Users</div> </li>
                <li class="tab"> <img src="images/tag.png" width="20px" height="auto"> <div>Tags</div> </li>
            </ul>
        </div>

        <div class="middle-body-container">
            <div class="container">
                <div class="right-side">

                    <div class="user-info">
                        <img src="283359e25303cef2020747b5a535dfba.jpg" alt="User Image">
                        <span>Username</span>                     
                    </div>
                    <div class="bio"><!-- Extra no need -->
                        <h3>bio</h3>
                        <p>This is where the user's bio information will be displayed.</p>
                    </div>   
                    <div class="nav-buttons">
                        <div class="toggle-switch">
                            <button id="questionButton" class="active">Questions</button>
                            <button id="answerButton">Answers</button>
                        </div>
                        <input class="search-AQ" type="text" placeholder="Search....">
                    </div>

                    <div class="content-box question-box">
                        <!-- Question cards will be dynamically generated here -->
                    </div>
                    <div class="content-box answer-box" style="display: none;">
                        <!-- Answer cards will be dynamically generated here -->
                    </div>

                    <!-- Pagination for Question Cards -->
                    <div id="questionPagination" class="pagination"></div>

                    <!-- Pagination for Answer Cards -->
                    <div id="answerPagination" class="pagination" style="display: none;"></div>

                    <script src = "scripts/userHome.js"></script>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>