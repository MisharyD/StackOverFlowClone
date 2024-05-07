<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel = "stylesheet" href = "styles/homeStyle.css">
</head>
<body>
    <div class="header">
        <div class = "logo"> <a href="https://stackoverflow.com">
            <img src="images/image.png" alt="logo"></a>  <b>StackOverFlow</b>
        </div>
        <div class = "SrchBar">
        <form action="">
            <input type="text" name="searchBar" id="searchBar" placeholder="Search....">
        </form>
        </div>
            <div class = "acc" >Account</div>
            <div class = "login">Login</div>
            <div class = "signUp">SignUp</div>
    </div>
    <div class="body">
        <div class = "container">
            <div class = "left-body-container">
                <ul class = "tab-container">
                    <li class = "current-page tab"> <div><img src = "images/homeIcon.png" width = "20px" height = auto></div> <div>Home</div> </li>
                    <li class = "tab"> <img src = "images/user.png" width = "20px" height = auto> <div> Users</div> </li>
                    <li class = "tab"> <img src = "images/tag.png" width = "20px" height = auto> <div>Tags</div> </li>
                </ul>
            </div>

            <div class = "middle-body-container">
                <input class = "ask-question" type = "button" name = "ask-question" value = "Ask Question">
                <div class = "top-questions-container">
                    <div class = "card"></div>
                </div>
                <div class = "recent-questions-container">

                </div> 
            </div>

            <div class = "right-body-container">
                <div class = "dashboard-container">
                    <div> Nb of questions asked:</div>
                    <div> Nb of comments commented:</div>
                    <div> Nb of Answers answered:</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
