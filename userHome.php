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
<div class="header">
    <div class="logo"> <a href="logo-stackoverflow.png">
        <img src="images/stack.png" alt="logo"></a> <b>StackOverFlow</b>
    </div>
    <div class="SrchBar">
        <form action="">
            <input style="padding-left:15px" type="text" name="searchBar" id="searchBar" placeholder="Search....">
        </form>
    </div>
    <div class="acc"><svg style="color: orange;" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
        </svg>
    </div>
    <div class="login"><a href="https://stackoverflow.com" id="login-hover" style="display: flex;
        justify-content: center;
        align-items: center; text-decoration: none" >Login</a>
    </div>
    <div class="signUp"><a href="https://stackoverflow.com" id="login-hover" style="display: flex;
        justify-content: center;
        align-items: center;text-decoration: none;">Sign-Up</a>
    </div>
</div>

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