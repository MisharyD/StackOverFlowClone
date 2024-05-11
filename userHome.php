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
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/cards.css">
    <link rel="stylesheet" href="styles/userHome.css">
</head>
<body>
<!-- Header part-->
<?php include ("LoggedIn-header.php"); ?>

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
            <div class="user-info">
                <img src = "images/user.png" alt="User Image">
                <span>Username</span>                     
            </div>
            <div class="bio">
                <h3>bio</h3>
                <p>This is where the user's bio information will be displayed.</p>
            </div>
                <div class="toggle-switch">
                    <button type = "button" class ="QA-button" id = "question-type">Questions</button> 
                    <button type = "button" class ="QA-button" id = "answer-type">Answers</button>
                </div>
            <div class="container pages-container" id = "questions-pages-container">
                <div class="questionCard" id="card" style = "display: none;" > <!--container of one card-->
                        <div class="left-container">
                            <!--div that consist of votes div, answers div, and question-content-tag-->
                            <div class="answers">
                                <p id="qAnswers">0</p> <!--number of answers here -->
                                <p> answers </p>
                            </div>
                            <div class="question-content-tag">
                                <div><a id="question" href="#">Question here </a></div>
                                <p id="qTag"></p> <!--tags (each tag will have a span)-->
                            </div>
                        </div>
                        <div class="time" id="qTime">
                            asked 3 months ago by Abcd
                        </div>
                    </div>
            </div>
            <div class="container pages-container" id = "answers-pages-container" style = "display: none">
                <div class="answerCard" id="card" style = "display: none;">
                    <div class="left-container">
                        <div class="answers">
                            <p id="aRating">0</p> 
                            <p> AVG Rating </p>
                        </div>
                        <div class="question-content-tag">
                            <div class = "text"><a id="answer" href="#">Answer here </a></div>
                            <p id="qTag"></p> <!--tags (each tag will have a span)-->
                        </div>
                    </div>
                    <div class="time" id="aTime">
                        answered 3 months ago by Abcd
                    </div>
                </div>
            </div>
            <div class = "question-pages-button-container" id = "question-pages-button-container">
                <button type= "button" class = "pageButton" id ="pageButton" style = "display:none" >nb</button>
            </div>
            <div class = "answer-pages-button-container" id = "answer-pages-button-container" style = "display:none">
                <button type= "button" class = "pageButton" id ="pageButton" style = "display:none" >nb</button>
            </div>
        </div>
    </div>
</div>
    <script src = "scripts/pages.js"></script>
</body>
</html>

 <?php 
     $result = mysqli_query($conn,"SELECT q.question_id, q.username, q.title, q.description, q.created_at, COUNT(a.answer_id) AS num_answers
     FROM question q
     join answer a on q.question_id = a.question_id
     GROUP BY q.question_id, q.title, q.description
     ORDER BY q.created_at DESC");

    echo "";

    $questions = array();
    while($row = mysqli_fetch_assoc($result))
        $questions[] = $row;
    $tags = array();
    for($i = 0; $i< count($questions); $i++)
     {
        $tags[$i] = array();
        $curr = $questions[$i]["question_id"];
        $result = mysqli_query($conn,"SELECT tagName FROM tag WHERE question_id = $curr");
        while($row = mysqli_fetch_assoc($result))
        $tags[$i][] = $row;
     }

    $nbOfQuestions = count($questions);
    $questions  = json_encode($questions);
    $tags = json_encode($tags);
    $containerId = "questions-pages-container";
    echo "<script>";
    //addQuestions() is called here to ensure that addRecentQuestionsInfo() is only called after the cards are loaded
    echo "addQuestionsPage($nbOfQuestions, '$containerId'); addQuestionsInfo($questions, $tags, '$containerId');";    
    echo "</script>"; 
?> 

<?php 
     $result = mysqli_query($conn,"SELECT *
     FROM answer
     ORDER BY created_at DESC");

    $answers = array();
    while($row = mysqli_fetch_assoc($result))
        $answers[] = $row;

    $rating = array();
    for($i = 0; $i< count($answers); $i++)
    {
        $rating[$i] = array();
        $curr = $answers[$i]["answer_id"];
        $result = mysqli_query($conn,"SELECT rating FROM rating WHERE answer_id = $curr");
        while($row = mysqli_fetch_assoc($result))
            $rating[$i][] = $row;
    }

    $avgRating = array();
    for($i = 0; $i< count($rating); $i++)
    {
        $sum = 0;
        for($j = 0; $j<count($rating[$i]); $j++)
            $sum += $rating[$i][$j]['rating'];
        if(count($rating[$i]) != 0)
            $avgRating[] = $sum / count($rating[$i]);
        else
            $avgRating[] = 0;

    }

    $tags = array();
    for($i = 0; $i< count($answers); $i++)
     {
        $tags[$i] = array();
        $curr = $answers[$i]["question_id"];
        $result = mysqli_query($conn,"SELECT tagName FROM tag WHERE question_id = $curr");
        while($row = mysqli_fetch_assoc($result))
        $tags[$i][] = $row;
     }

    $nbOfAnswers = count($answers);
    $answers  = json_encode($answers);
    $avgRating = json_encode($avgRating);
    $tags = json_encode($tags);
    $containerId = "answers-pages-container";
    echo "<script>";
    //addQuestions() is called here to ensure that addRecentQuestionsInfo() is only called after the cards are loaded
    echo "addAnswersPage($nbOfAnswers, '$containerId'); addAnswersInfo($answers, $avgRating , $tags, '$containerId');";     
    echo "</script>"; 
?> 

