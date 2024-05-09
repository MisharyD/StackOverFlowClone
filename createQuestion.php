<!-- line 54 Extra no need for bio -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/test.css">
</head>
<body>
<!-- Header part-->
<?php include("header.php");?>;
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
                    <form action="" method="POST">
                        <label for="questionTitle">Title:</label>
                        <input type="text" id="questionTitle" name="questionTitle" required><br><br>
                
                        <label for="questionDescription">Description:</label><br>
                        <textarea id="questionDescription" name="questionDescription" rows="4" cols="50" required></textarea><br><br>
                
                        <label for="questionTags">Tags:</label>
                        <input type="text" id="questionTags" name="questionTags" required><br><br>
                
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>