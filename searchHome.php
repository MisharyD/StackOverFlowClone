<?php
session_start();
include ("database.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/cards.css">
    <link rel="stylesheet" href="styles/pagination.css">

    <style>
        .noResult {
            position: absolute;
            top: 30%;
            left: 45%;
            font-size: 2em;
        }
    </style>
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
                        <img src="images/homeIcon.png" width="20px" height=auto>
                        <div>Home</div>
                    </li>
                    <li class="tab">
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

                <h1>Search Results</h1> <!--header of the set-->
                <!--the question tag-->
                <div class="question-container" id="recent-questions-container"
                    style="overflow:visible; max-height: 700px;">
                    <!--container of the whole cards-->
                    <div class="question" id="card" style="display:none"> <!--container of one card-->
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
                <!-- Pagination container -->
                <div class="pagination" id="pagination-container">
                    <?php
                    $search_query = mysqli_real_escape_string($conn, $_GET['searchBar']);
                    $page_result = mysqli_query($conn, "SELECT q.question_id, q.username, q.title, q.description, q.created_at, COUNT(a.answer_id) AS num_answers
                                                        FROM question q
                                                        JOIN answer a ON q.question_id = a.question_id
                                                        WHERE q.title LIKE '%$search_query%'
                                                        GROUP BY q.question_id, q.title, q.description
                                                        ORDER BY q.created_at DESC
                                                        ");

                    $total_records = mysqli_num_rows($page_result);
                    $total_pages = ceil($total_records / 7);

                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "<a href='searchHome.php?page=$i&searchBar=" . urlencode($search_query) . "' class='pagination-link'>$i</a>";
                    }
                    ?>
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
        <script src='scripts/cards.js'></script>

</body>

</html>

<!-- retrive data about recent questions-->
<?php
// Check if search query is provided
if (isset($_GET['searchBar'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['searchBar']);
} else {
    // If no search query is provided, set it to an empty string
    $search_query = '';
}

// Pagination Code
$items_per_page = 7;
$page = '';

if (isset($_GET['page'])) {

    $page = $_GET['page'];

} else {
    $page = 1;
}

$start_from = ($page - 1) * $items_per_page;

$result = mysqli_query($conn, "SELECT q.question_id, q.username, q.title, q.description, q.created_at, COUNT(a.answer_id) AS num_answers
FROM question q
JOIN answer a ON q.question_id = a.question_id
WHERE q.title LIKE '%$search_query%'
GROUP BY q.question_id, q.title, q.description
ORDER BY q.created_at DESC
LIMIT $start_from, $items_per_page");



$recentQuestions = array();
while ($row = mysqli_fetch_assoc($result)) {
    $recentQuestions[] = $row;
}

// Check if there are any search results
if (empty($recentQuestions)) {
    echo "<p class='noResult'>No results found.</p>";
} else {
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
    echo "<script>";
    //addQuestions() is called here to ensure that addRecentQuestionsInfo() is only called after the cards are loaded
    echo "addQuestions('$containerId'); addQuestionsInfo($recentQuestions, $tags, '$containerId');";
    echo "</script>";
}
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

<script>
    // Once you have fetched the data, you can insert it into the corresponding HTML elements using JavaScript
    document.querySelector('.noq').textContent = "<?php echo $numQuestions; ?>";
    document.querySelector('.noc').textContent = "<?php echo $numComments; ?>";
    document.querySelector('.noa').textContent = "<?php echo $numAnswers; ?>";
</script>
