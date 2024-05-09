<!-- line 54 Extra no need for bio -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/test.css">
    <link rel="stylesheet" href="styles/home.css">
</head>
<body>
<!-- Header part-->
<?php include("header.php");?>;
<!-- Body part-->
<div class="body">
    <div class="container">
    <div class="left-body-container">
                <ul class="tab-container">
                    <li class="tab">
                        <img src="images/homeIcon.png" width="20px" height=auto>
                        <div>Home</div>
                    </li>
                    <li class="current-page tab"> 
                        <img src="images/question.png" width="15px" height=auto>
                        <div> Questions</div>
                    </li>
                    <li class="tab"> 
                        <img src="images/user.png" width="20px" height=auto>
                        <div> Users</div>
                    </li>
                    <li class="tab"> <img src="images/tag.png" width="20px" height=auto>
                        <div>Tags</div>
                    </li>
                </ul>
            </div>

        <div class="middle-body-container">
            <div class="container">
                <div class="right-side">

                    <div class="bio"><!-- Extra no need -->
                        <h2>Search Result</h2>
                    </div>   

                    <div class="content-box question-box">
                        <!-- Question cards will be dynamically generated here -->
                    </div>

                    <!-- Pagination for Question Cards -->
                    <div id="questionPagination" class="pagination"></div>

                    <script src = "searchHome.js"></script>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>