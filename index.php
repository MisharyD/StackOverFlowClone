<?php
    include("database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <!-- Header part-->
    <div class="header">
        <div class="logo"> <a href="https://stackoverflow.com">
                <img src="images/stack.png" alt="logo"></a> <b>StackOverFlow</b>
        </div>
        <div class="SrchBar">
            <form action="">
                <input style="padding-left:15px" type="text" name="searchBar" id="searchBar" placeholder="Search....">
            </form>
        </div>
        <div class="acc"><svg style="color: orange;" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
        </div>
        <div class="login"><a href="https://stackoverflow.com" id="login-hover" style="display: flex;
            justify-content: center;
            align-items: center; text-decoration: none">Login</a>
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
                    <li class="current-page tab">
                        <div><img src="images/homeIcon.png" width="20px" height=auto></div>
                        <div>Home</div>
                    </li>
                    <li class="tab"> <img src="images/user.png" width="20px" height=auto>
                        <div> Users</div>
                    </li>
                    <li class="tab"> <img src="images/tag.png" width="20px" height=auto>
                        <div>Tags</div>
                    </li>
                </ul>
            </div>

            <div class="middle-body-container">
                <input class="ask-question" type="button" name="ask-question" value="Ask Question">
                <h1>Recent Questions</h1> <!--header of the set-->
                <!--the question tag-->
                <div class="question-container" id = "recent-questions-container"> <!--container of the whole cards-->
                    <div class="question" id="card" style = "display:none"> <!--container of one card-->
                        <div class="left-container"> <!--div that consist of votes div, answers div, and question-content-tag-->
                            <div class="answers">
                                <p id="qAnswers">0</p> <!--number of answers here -->
                                <p> answers </p>
                            </div>
                            <div class="question-content-tag">
                                <div><a id="question" href="#">Question here </a></div>
                                <p id = "qTag"></p> <!--tags (each tag will have a span)-->
                            </div>
                        </div>
                        <div class="time" id ="qTime">
                            asked 3 months ago by Abcd
                        </div>
                    </div>
                </div>
                <h1> Top Questions</h1>
                <div class="question-container" id = "top-questions-container"> <!--container of the whole cards-->
                    <div class="question"> <!--container of one card-->
                        <div class="left-container"> <!--div that consist of votes div, answers div, and question-content-tag-->
                            <div class="answers">
                                <p id="answerQ1">0</p> <!--number of answers here -->
                                <p> answers </p>
                            </div>
                            <div class="question-content-tag">
                                <div><a id="Q1" href="#">Question here </a></div>
                                <p> <span class="tag"> #alpha </span> <span class="tag"> JS</span> </p> <!--tags (each tag will have a span)-->
                            </div>
                        </div>

                        <div class="time" id = "qTime">
                            asked 3 months ago by Abcd
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-body-container">
                <div class="dashboard-container">
                    <div> Nb of questions asked:</div>
                    <div> Nb of comments commented:</div>
                    <div> Nb of Answers answered:</div>
                </div>
            </div>
        </div>
    </div>
    <script src= 'scripts/cards.js'></script>
</body>
</html>
<?php
        $result = mysqli_query($conn,"SELECT * FROM question ORDER BY created_at DESC LIMIT 10;");

        $recentQuestions = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $recentQuestions[] = $row;
        }

        $result  = mysqli_query($conn, "SELECT COUNT(a.answer_id) AS num_answers FROM question q 
        JOIN answer a ON q.question_id = a.question_id GROUP BY q.question_id, q.title
        ORDER BY q.created_at DESC LIMIT 10;");

        $nbOfVotesForRecent = array(); 
        while($row = mysqli_fetch_assoc($result))
        {
            $nbOfVotesForRecent[] = $row;
        }

        //an array which also contain an array for tags for every question
        $tags = array();
        for($i = 0; $i< count($recentQuestions); $i++)
        {
            $tags[$i] = array();
            $curr = $recentQuestions[$i]["question_id"];
            $result = mysqli_query($conn,"SELECT tagName FROM tag WHERE question_id = $curr");
            while($row = mysqli_fetch_assoc($result))
                $tags[$i][] = $row;
        }

        $recentQuestions = json_encode($recentQuestions);
        $nbOfVotesForRecent = json_encode($nbOfVotesForRecent);
        $tags = json_encode($tags);
        echo "<script>";
        //addQuestions() is called here to ensure that addRecentQuestionsInfo() is only called after the cards are loaded
        echo "addQuestions(); addRecentQuestionsInfo($recentQuestions, $nbOfVotesForRecent, $tags);";
        echo "</script>";
?>