<?php
session_start();
include("database.php");
?>
<?php
    // Query to count the number of questions
    $queryQuestions = "SELECT COUNT(*) AS num_questions FROM question";
    $resultQuestions = mysqli_query($conn, $queryQuestions);
    $rowQuestions = mysqli_fetch_assoc($resultQuestions);
    $numQuestions = $rowQuestions['num_questions'];

    // Query to count the number of comments
    $queryComments = "SELECT COUNT(*) AS num_comments FROM comment";
    $resultComments = mysqli_query($conn, $queryComments);
    $rowComments = mysqli_fetch_assoc($resultComments);
    $numComments = $rowComments['num_comments'];

    // Query to count the number of answers
    $queryAnswers = "SELECT COUNT(*) AS num_answers FROM answer";
    $resultAnswers = mysqli_query($conn, $queryAnswers);
    $rowAnswers = mysqli_fetch_assoc($resultAnswers);
    $numAnswers = $rowAnswers['num_answers'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stack Overflow</title>
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>

<body>
    <!-- Header part-->

    <?php

    if (isset($_SESSION["username"])) {
        include "LoggedIn-header.php";
    } else {
        include "notLoggedIn-header.php";
    }

    ?>

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
                <div id="delete-question-message" class="delete-message" style="display:none"> Question was deleted succefully! </div>
                <div id="delete-answer-message" class="delete-message" style="display:none"> Answer was deleted succefully! </div>
                <a class="ask-question" href="createQuestion.php">Ask Question</a>

                <h1>Recent Questions</h1> <!--header of the set-->
                <!--the question tag-->
                <div class="question-container" id="recent-questions-container"> <!--container of the whole cards-->
                    <div class="questionCard" id="card" style="display:none"> <!--container of one card-->
                        <div class="left-container">
                            <!--div that consist of votes div, answers div, and question-content-tag-->
                            <div class="answers">
                                <p id="qAnswers">0</p> <!--number of answers here -->
                                <p> answers </p>
                            </div>
                            <div class="question-content-tag">
                                <div><a id="question" class="qat" href="question.php">Question here </a></div>
                                <p id="qTag"></p> <!--tags (each tag will have a span)-->
                            </div>
                        </div>
                        <div class="right-container">
                            <div class="toggle-delEdit-buttons" style="visibility: hidden;">
                                <button id="del" class="delete-edit-buttons delete">Delete</button>
                                <button id="edit" class="delete-edit-buttons edit">Edit</button>
                            </div>
                            <div class="time" id="qTime">
                                answered 3 months ago by Abcd
                            </div>
                        </div>
                    </div>
                </div>
                <h1> Top Questions</h1>
                <div class="question-container" id="top-questions-container"> <!--container of the whole cards-->
                    <div class="questionCard" style="display:none"> <!--container of one card-->
                        <div class="left-container"> <!--div that consist of votes div, answers div, and question-content-tag-->
                            <div class="answers">
                                <p id="qAnswers">0</p> <!--number of answers here -->
                                <p> answers </p>
                            </div>
                            <div class="question-content-tag">
                                <div><a id="question" class="qat" href="question.php">Question here </a></div>
                                <p> <span class="tag"> #alpha </span> <span class="tag"> JS</span> </p>
                                <!--tags (each tag will have a span)-->
                            </div>
                        </div>
                        <div class="right-container">
                            <div class="toggle-delEdit-buttons" style="visibility: hidden;">
                                <button id="del" class="delete-edit-buttons delete">Delete</button>
                                <button id="edit" class="delete-edit-buttons edit">Edit</button>
                            </div>
                            <div class="time" id="qTime">
                                answered by mishary at 2024-05-03 04:30:00 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-body-container">
                <div class="dashboard-container">
                    <div class="numOfQuestions">Number Of Questions: <div class="noq">1</div>
                    </div>
                    <div class="numOfComments">Number Of Comments: <div class="noc">11</div>
                    </div>
                    <div class="numOfAnswers">Number Of Answers: <div class="noa">121</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='scripts/cards.js'></script>
    <!-- Dashboard -->
    <script>
        // Once you have fetched the data, you can insert it into the corresponding HTML elements using JavaScript
        document.querySelector('.noq').textContent = "<?php echo $numQuestions; ?>";
        document.querySelector('.noc').textContent = "<?php echo $numComments; ?>";
        document.querySelector('.noa').textContent = "<?php echo $numAnswers; ?>";
        // Pass the link value to question.php
    </script>
    <script src = "scripts/questionLink.js"></script>
    <script src = "scripts/deleteEditQA.js"></script>
</body>

</html>

<!-- retrive data about recent questions-->
<?php
    $result = mysqli_query($conn, "SELECT q.question_id, q.username, q.title, q.description, q.created_at, COUNT(a.answer_id) AS num_answers
        FROM question q
        LEFT JOIN answer a on q.question_id = a.question_id
        GROUP BY q.question_id, q.title, q.description
        ORDER BY q.created_at DESC
        LIMIT 10;");

    $recentQuestions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $recentQuestions[] = $row;
    }

    //an array which also contain an array for tags for every question
    $tags = array();
    for ($i = 0; $i < count($recentQuestions); $i++) {
        $tags[$i] = array();
        $curr = $recentQuestions[$i]["question_id"];
        $result = mysqli_query($conn, "SELECT tagName FROM tag WHERE question_id = $curr");
        while ($row = mysqli_fetch_assoc($result))
            $tags[$i][] = $row;
    }

    $recentQuestions = json_encode($recentQuestions);
    $tags = json_encode($tags);
    $containerId = "recent-questions-container";
    if (!isset($_SESSION["username"])) {
        echo "<script>";
        //addQuestions() is called here to ensure that addRecentQuestionsInfo() is only called after the cards are loaded
        echo "addQuestions('$containerId',10); addQuestionsInfo($recentQuestions, $tags, '$containerId');";
        echo "</script>";
    } else {
        $currUsername = $_SESSION["username"];
        echo "<script>";
        //addQuestions() is called here to ensure that addRecentQuestionsInfo() is only called after the cards are loaded
        echo "addQuestions('$containerId',10); addQuestionsInfoAndButtons($recentQuestions, $tags, '$containerId', '$currUsername');";
        echo "</script>";
    }
?>

<!-- retrive data about top questions-->
<?php
    $result = mysqli_query($conn, "SELECT q.question_id, q.username, q.title, q.description, q.created_at, COUNT(a.answer_id) AS num_answers
        FROM question q
        LEFT JOIN answer a ON q.question_id = a.question_id
        GROUP BY q.question_id, q.title, q.description
        ORDER BY num_answers DESC
        LIMIT 10;");

    $topQuestions = array();
    while ($row = mysqli_fetch_assoc($result))
        $topQuestions[] = $row;

    //an array which also contain an array for tags for every question
    $tags = array();
    for ($i = 0; $i < count($topQuestions); $i++) {
        $tags[$i] = array();
        $curr = $topQuestions[$i]["question_id"];
        $result = mysqli_query($conn, "SELECT tagName FROM tag WHERE question_id = $curr");
        while ($row = mysqli_fetch_assoc($result))
            $tags[$i][] = $row;
    }

    $topQuestions = json_encode($topQuestions);
    $tags = json_encode($tags);
    $containerId = "top-questions-container";
    if (!isset($_SESSION["username"])) {
        echo "<script>";
        //addQuestions() is called here to ensure that addRecentQuestionsInfo() is only called after the cards are loaded
        echo "addQuestions('$containerId',10); addQuestionsInfo($topQuestions, $tags, '$containerId');";
        echo "</script>";
    } else {
        $currUsername = $_SESSION["username"];
        echo "<script>";
        //addQuestions() is called here to ensure that addRecentQuestionsInfo() is only called after the cards are loaded
        echo "addQuestions('$containerId',10); addQuestionsInfoAndButtons($topQuestions, $tags, '$containerId', '$currUsername');";
        echo "</script>";
    }
?>

<!-- delete card -->
<?php
    //$_GET["title"] may be a title for a question or a description of an answer
    if (isset($_GET["type"]) && isset($_GET["deletePram"])) {
        if ($_GET["type"] == "true") {
            mysqli_query($conn,"DELETE FROM question WHERE title = '{$_GET['deletePram']}' ");
            echo "<script>window.location.href ='userHome.php?deleted=' + encodeURIComponent('question') </script>";
        } else {
            mysqli_query($conn,"DELETE FROM answer WHERE description = '{$_GET['deletePram']}' ");
            echo "<script>window.location.href ='userHome.php?deleted=' + encodeURIComponent('answer') </script>";
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