<?php
session_start();
//check if user is logged in -->
if (!isset($_SESSION["username"]))
    header("Location: signIn.php");

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
    <title>Stack Overflow</title>
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/cards.css">
    <link rel="stylesheet" href="styles/userHome.css">
    <style>
        .confMsg {
            background-color: #297d29;
            color: white;
            padding: 7px;
            font-weight: bold;
            width: fit-content;
            border-radius: 7px;
            <?php
            if (isset($_SESSION['editAnswerStatus']) || isset($_SESSION['editQuestionStatus'])) {
                echo 'display:block';
            } else {
                echo 'display:none';
            }

            ?>
        }
        </style>
</head>

<body>
    <!-- Header part-->
    <?php include("LoggedIn-header.php"); ?>

    <!-- Body part-->
    <div class="body">
        <div class="container">
            <div class="left-body-container">
            <ul class="tab-container">
                    <li class="current-page tab">
                        <a href="index.php">
                            <img src="images/homeIcon.png" width="20px" height=auto>
                            <div>Home</div>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="userHome.php">
                            <img src="images/user.png" width="20px" height=auto>
                            <div>Profile</div>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="searchHome.php">
                            <img src="images/question.png" width="15px" height=auto>
                            <div> Questions</div>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="tags.php">
                            <img src="images/tag.png" width="20px" height=auto>
                            <div>Tags</div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="middle-body-container">
            <p class="confMsg">

                <?php

                if (isset($_SESSION['editQuestionStatus'])) {
                    echo $_SESSION['editQuestionStatus'];
                    unset($_SESSION['editQuestionStatus']);
                } 
                elseif ($_SESSION['editAnswerStatus']){
                    echo $_SESSION['editAnswerStatus'];
                    unset($_SESSION['editAnswerStatus']);
                }

                ?>

                </p>
                <div id="delete-question-message" class="delete-message" style="display:none"> Question was deleted succefully! </div>
                <div id="delete-answer-message" class="delete-message" style="display:none"> Answer was deleted succefully! </div>
                <div class="user-info">
                    <img src="images/user.png" alt="User Image">
                    <span id = "username">Username</span>
                </div>
                <div class="toggle-switch">
                    <button type="button" class="QA-button" id="question-type">Questions</button>
                    <button type="button" class="QA-button" id="answer-type">Answers</button>
                </div>
                <div class="container pages-container" id="questions-pages-container">
                    <div class="questionCard" id="card" style="display: none;"> <!--container of one card-->
                        <div class="left-container">
                            <!--div that consist of votes div, answers div, and question-content-tag-->
                            <div class="answers">
                                <p id="qAnswers">0</p> <!--number of answers here -->
                                <p> answers </p>
                            </div>
                            <div class="question-content-tag">
                                <div><a id="question" class = "qat" href="#">Question here </a></div>
                                <p id="qTag"></p> <!--tags (each tag will have a span)-->
                            </div>
                        </div>
                        <div class="right-container">
                            <div>
                                <button class="delete-edit-buttons delete">Delete</button>
                                <button class="delete-edit-buttons edit">Edit</button>
                            </div>
                            <div class="time" id="qTime">
                                answered 3 months ago by Abcd
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container pages-container" id="answers-pages-container" style="display: none">
                    <div class="answerCard" id="card" style="display: none;">
                        <div class="left-container">
                            <div class="answers">
                                <p id="aRating">0</p>
                                <p> AVG Rating </p>
                            </div>
                            <div class="question-content-tag">
                                <div class="text"><a id="answer" href="#" >Answer here </a></div>
                                <p id="qTag"></p>
                            </div>
                        </div>
                        <div class="right-container">
                            <div>
                                <button class="delete-edit-buttons delete">Delete</button>
                                <button class="delete-edit-buttons editAnswer">Edit</button>
                            </div>
                            <div class="time" id="aTime">
                                answered 3 months ago by Abcd
                            </div>
                        </div>
                    </div>
                </div>
                <div class="question-pages-button-container" id="question-pages-button-container">
                    <button type="button" class="pageButton" id="pageButton" style="display:none">nb</button>
                </div>
                <div class="answer-pages-button-container" id="answer-pages-button-container" style="display:none">
                    <button type="button" class="pageButton" id="pageButton" style="display:none">nb</button>
                </div>
            </div>
        </div>
    </div>
    <script src="scripts/pages.js"></script>
    <script src = "scripts/deleteEditQA.js"></script>
    <script src = "scripts/questionLink.js"></script>
</body>

</html>


<!-- load questions -->
<?php
    $username = $_SESSION["username"];
    $result = mysqli_query($conn, "SELECT q.question_id, q.username, q.title, q.description, q.created_at, COUNT(a.answer_id) AS num_answers
        FROM question q
        LEFT join answer a on q.question_id = a.question_id
        WHERE q.username = '$username'
        GROUP BY q.question_id, q.title, q.description
        ORDER BY q.created_at DESC");

    $questions = array();
    while ($row = mysqli_fetch_assoc($result))
        $questions[] = $row;
    $tags = array();
    for ($i = 0; $i < count($questions); $i++) {
        $tags[$i] = array();
        $curr = $questions[$i]["question_id"];
        $result = mysqli_query($conn, "SELECT tagName FROM tag WHERE question_id = $curr");
        while ($row = mysqli_fetch_assoc($result))
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

<!-- load answers -->
<?php
    $result = mysqli_query($conn, "SELECT *
        FROM answer
        WHERE username = '$username'
        ORDER BY created_at DESC");

    $answers = array();
    while ($row = mysqli_fetch_assoc($result))
        $answers[] = $row;

    $rating = array();
    for ($i = 0; $i < count($answers); $i++) {
        $rating[$i] = array();
        $curr = $answers[$i]["answer_id"];
        $result = mysqli_query($conn, "SELECT rating FROM rating WHERE answer_id = $curr");
        while ($row = mysqli_fetch_assoc($result))
            $rating[$i][] = $row;
    }

    $avgRating = array();
    for ($i = 0; $i < count($rating); $i++) {
        $sum = 0;
        for ($j = 0; $j < count($rating[$i]); $j++)
            $sum += $rating[$i][$j]['rating'];
        if (count($rating[$i]) != 0)
            $avgRating[] = $sum / count($rating[$i]);
        else
            $avgRating[] = 0;
    }

    $tags = array();
    for ($i = 0; $i < count($answers); $i++) {
        $tags[$i] = array();
        $curr = $answers[$i]["question_id"];
        $result = mysqli_query($conn, "SELECT tagName FROM tag WHERE question_id = $curr");
        while ($row = mysqli_fetch_assoc($result))
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

<!-- delete card -->
<?php
    //$_GET["title"] may be a title for a question or a description of an answer
    if (isset($_GET["type"]) && isset($_GET["deletePram"])) {
        if ($_GET["type"] == "true") {
            mysqli_query($conn,"DELETE FROM question WHERE title = '{$_GET['deletePram']}' ");
            echo "<script>window.location.href ='index.php?deleted=' + encodeURIComponent('question') </script>";
        } else {
            mysqli_query($conn,"DELETE FROM answer WHERE description = '{$_GET['deletePram']}' ");
            echo "<script>window.location.href ='index.php?deleted=' + encodeURIComponent('answer') </script>";
        }
    }
?>

    <!-- show deleted message -->
    <?php
        if (isset($_GET["deleted"])) {
            if ($_GET["deleted"] == "question")
                echo "<script>document.querySelector('#delete-question-message ').style.display = 'block' </script>";
            else if ($_GET["deleted"] == "answer")
                echo "<script>document.querySelector('#delete-answer-message').style.display = 'block' </script>";
        }
    ?>

<!-- add user info -->
<?php 
    echo "<script> document.addEventListener('DOMContentLoaded', () => document.querySelector('#username').innerHTML = '{$_SESSION['username']}') </script>";
?>