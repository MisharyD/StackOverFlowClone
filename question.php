<?php

session_start();
include ("database.php");

if (isset($_GET['qat'])) {
    $questionTitle = htmlspecialchars($_GET['qat']);
} elseif (isset($_POST['qat'])) {
    $questionTitle = htmlspecialchars($_POST['qat']);
} else {
    echo "no question";
    header("Location: index.php");
    exit();
}

$questionInfo = mysqli_query($conn, "SELECT q.question_id, q.userName, q.description, q.created_at, IFNULL(GROUP_CONCAT(t.tagName SEPARATOR ', '), 'None') AS tag
FROM question q
LEFT JOIN tag t ON q.question_id = t.question_id
WHERE q.title = '$questionTitle'");


// Check if any rows were returned
if ($row = mysqli_fetch_assoc($questionInfo)) {
    // Store question details in variables
    $question_id = $row["question_id"];
    $username = $row["userName"];
    $description = $row["description"];
    $created_at = $row["created_at"];

    // Store tag name
    if ($row["tag"] == "")
        $tag = "None";
    else {
        $tag = $row["tag"];
    }
} else {
    echo "Question not found.";
    exit();
}

// Scenario 1: All comments for a certain question
$commentsQuery = "SELECT description, userName, created_at
FROM comment
WHERE question_id = '$question_id'";
$commentsResult = mysqli_query($conn, $commentsQuery);

// Scenario 2: All answers for a certain question with ratings
$answersQuery = "SELECT a.answer_id, a.description, a.userName, r.rating, a.created_at,
AVG(r.rating) AS avgRating
FROM answer a
LEFT JOIN rating r ON a.answer_id = r.answer_id
WHERE a.question_id = '$question_id'
GROUP BY a.answer_id";
$answersResult = mysqli_query($conn, $answersQuery);



// Handle question comment submission
if (isset($_POST['question_comment'])) {
    if (!isset($_SESSION['username']) && !isset($_COOKIE['remember_user'])) {
        // User is not logged in, display a message or redirect to the login page
        echo "<script>alert('You need to be logged in to add a comment.')</script>";

    } else {
        $questionComment = $_POST['question_comment'];
        $username = $_SESSION['username'];
        $createdAt = date('Y-m-d H:i:s');

        // Insert the comment into the database
        $insertQuestionCommentQuery = "INSERT INTO comment (question_id, userName, description, created_at)
                                    VALUES ('$question_id', '$username', '$questionComment', '$createdAt')";
        mysqli_query($conn, $insertQuestionCommentQuery);
        // Redirect to question.php after inserting
        header("Location: question.php?qat=$questionTitle");
        exit();
    }
}

// Handle answer comment submission
if (isset($_POST['answer_comment'])) {

    if (!isset($_SESSION['username']) && !isset($_COOKIE['remember_user'])) {
        // User is not logged in, display a message or redirect to the login page
        echo "<script>alert('You need to be logged in to add a comment.')</script>";

    } else {
        $answerId = $_POST['answer_id'];
        $questionTitle = $_POST['qat'];
        $answerComment = $_POST['answer_comment'];
        $username = $_SESSION['username'];
        $createdAt = date('Y-m-d H:i:s');

        // Insert the comment into the database
        $insertAnswerCommentQuery = "INSERT INTO comment (answer_id, userName, description, created_at)
                                    VALUES ('$answerId', '$username', '$answerComment', '$createdAt')";
        mysqli_query($conn, $insertAnswerCommentQuery);
        // Redirect to question.php after inserting
        header("Location: question.php?qat=$questionTitle");
        exit();
    }
}

// Handle answer submission
if (isset($_POST['answer'])) {

    if (!isset($_SESSION['username']) && !isset($_COOKIE['remember_user'])) {
        // User is not logged in, display a message or redirect to the login page
        echo "<script>alert('You need to be logged in to add an answer.')</script>";

    } else {
        $answerDescription = $_POST['answer'];
        $username = $_SESSION['username'];
        $createdAt = date('Y-m-d H:i:s');

        // Insert the answer into the database
        $insertAnswerQuery = "INSERT INTO answer (question_id, userName, description, created_at)
                                VALUES ('$question_id','$username' , '$answerDescription', '$createdAt')";
        mysqli_query($conn, $insertAnswerQuery);
        // Redirect to question.php after inserting
        header("Location: question.php?qat=$questionTitle");
        exit();
    }

}

// Handle rating submission
if (isset($_GET['rating'])) {
    if (!isset($_SESSION['username']) && !isset($_COOKIE['remember_user'])) {
        // User is not logged in, display a message or redirect to the login page
        echo "<script>alert('You need to be logged in to rate an answer.')</script>";

    } else {
        $answerId = $_GET['answer_id'];
        $rating = $_GET['rating'];
        $username = $_SESSION['username'];
        $createdAt = date('Y-m-d H:i:s');

        // Check if the user has already rated the answer
        $checkRatingQuery = "SELECT * FROM rating WHERE answer_id = '$answerId' AND userName = '$username'";
        $result = mysqli_query($conn, $checkRatingQuery);

        if (mysqli_num_rows($result) > 0) {
            // User has already rated this answer, display an alert and redirect
            echo "<script>alert('You have already rated this answer.')</script>";
        } else {
            // Insert the rating into the database
            $insertRatingQuery = "INSERT INTO rating (answer_id, userName, rating, created_at)
                                  VALUES ('$answerId', '$username', '$rating', '$createdAt')";
            mysqli_query($conn, $insertRatingQuery);
            // Redirect to question.php after inserting
            header("Location: question.php?qat=$questionTitle");
            exit();
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quesiton Page</title>
    <link rel="stylesheet" href="styles/home.css"> 
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/Qsty.css">
    <link rel="stylesheet" href="CSS/cards.css">
</head>

<body>

    <!-- Header part-->
    <?php
    if (isset($_SESSION["username"]) || isset($_COOKIE["remember_user"])) {
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
                    <li class="tab">
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

                <div class="question-container">
                    <div class="question-header">
                        <h1 class="question-title" id="Qtitle"><?php echo $questionTitle ?></h1>
                        <h6 class="question-description" id="Qdescription"><?php echo $description ?></h6>

                        <!-- <span class="tags-container"> -->
                        <span class="tag" id="tag"><?php echo $tag ?></span>
                        <!-- </span> -->


                        <div class="question-meta">
                            <!-- here is the informattion about the question, the user name and date ot the question -->
                            Asked by<span id="Qusername"> <?php echo $username ?></span> on <span class="question-date"
                                id="Qdate"><?php echo $created_at ?></span>
                        </div>

                        <!-- Question Comments Part -->
                        <!-- Display comments for the question -->
                        <div class="question-comments">
                            <?php while ($comment = mysqli_fetch_assoc($commentsResult)): ?>
                                <div class="comment">
                                    <p><?php echo $comment['description']; ?></p>
                                    <p>By: <?php echo $comment['userName']; ?> | <?php echo $comment['created_at']; ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <!-- Add quesiton comment section -->
                        <form action="question.php" method="POST">
                            <div class="addCommentForQuestion">
                            <div class="post-box">
                            <input type="button" class="btn-comment" value="Add a comment">
                                <input required class="text-comment formField" type=" text "
                                placeholder="Enter your comment here..." name="question_comment">
                                <input type="hidden" name="qat" value="<?php echo $questionTitle ?>">
                                <input type="submit" value="Submit Comment" class="submissionButton">
                            </div>
                            </div>
                        </form>
                    </div>

                    <!-- Answers Part -->
                    <div class="answers-section">
                        <h1 style="border-top: 1px solid black; padding: 20px 0px 5px 0px">Answers</h1>
                        <!-- Display answers for the question with their ratings -->
                        <div class="container-allAnswersWithItsComments">
                            <?php while ($answer = mysqli_fetch_assoc($answersResult)): ?>
                                <div class="answer">
                                    <p class="answer-description"><?php echo $answer['description']; ?></p>
                                    <p class="answer-meta">Answered by: <?php echo $answer['userName']; ?> on
                                        <?php echo $answer['created_at']; ?>
                                    </p>
                                    <p class="answer-meta"> Average Rating:
                                        <?php echo $answer['avgRating'];
                                        $answerId = $answer['answer_id'];
                                        ?>
                                    <form action="question.php" class="cont" method="GET">
                                        <input type="radio" id="star1_<?php echo $answerId; ?>" name="rating"
                                            value="1"><label for="star1_<?php echo $answerId; ?>">&#9733</label>

                                        <input type="radio" id="star2_<?php echo $answerId; ?>" name="rating"
                                            value="2"><label for="star2_<?php echo $answerId; ?>">&#9733</label>

                                        <input type="radio" id="star3_<?php echo $answerId; ?>" name="rating"
                                            value="3"><label for="star3_<?php echo $answerId; ?>">&#9733</label>

                                        <input type="radio" id="star4_<?php echo $answerId; ?>" name="rating"
                                            value="4"><label for="star4_<?php echo $answerId; ?>">&#9733</label>

                                        <input type="radio" id="star5_<?php echo $answerId; ?>" name="rating"
                                            value="5"><label for="star5_<?php echo $answerId; ?>">&#9733</label>
                                            <div>
                                        <input type="submit" value="Submit Rate" class = "rate-button">
                                        <input type="hidden" name="answer_id" value="<?php echo $answer['answer_id']; ?>">
                                        <input type="hidden" name="qat" value="<?php echo $questionTitle ?>">
                            </div>
                                    </form>
                           
                            
                                    <h2>Comments</h2>

                                    <!-- Scenario 3: All comments for this answer -->
                                    <?php

                                    $answerCommentsQuery = "SELECT description, userName, created_at
                                    FROM comment
                                    WHERE answer_id = $answerId";
                                    $answerCommentsResult = mysqli_query($conn, $answerCommentsQuery);
                                    ?>
                                    <div class="answer-comments">
                                        <?php while ($comment = mysqli_fetch_assoc($answerCommentsResult)): ?>
                                            <div class="comment">
                                                <p class="comment-description"><?php echo $comment['description']; ?></p>
                                                <p>By: <?php echo $comment['userName']; ?> |
                                                    <?php echo $comment['created_at']; ?>
                                                </p>
                                            </div>
                                        <?php endwhile; ?>
                                        <!-- Add answer comment section -->
                                        <form action="question.php" method="POST">
                                            <div class="addCommentForQuestion">
                                                <input type="hidden" name="answer_id"
                                                    value="<?php echo $answer['answer_id']; ?>">

                                                <input type="hidden" name="qat" value="<?php echo $questionTitle ?>">
                                                <div class="post-box">
                                                <input type="button" class="btn-comment" value="Add a comment">
                                                <input required class="text-comment formField" type=" text "
                                                    placeholder="Enter your comment here..." name="answer_comment">

                                                <input type="submit" value="Submit Comment" class="submissionButton">
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <form action="question.php" method="POST">
                        <div class="addAnswer">
                            <input required class="text-Answer formField" type=" text "
                                placeholder="Enter your Answer here..." name="answer">
                            <input type="hidden" name="qat" value="<?php echo $questionTitle ?>">

                            <input type="submit" value="Submit Answer" class="submitAnswer">
                        </div>
                    </form>

                </div>



                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                <script>
                    

                    // this function is to toggle the textarea when clicking on "Add a comment"
                     $(document).ready(function() { 
                        $(document).on('click', '.btn-comment', function() {
                            $(this).siblings('.text-comment').toggle(); // Toggle the associated comment box
                            $(this).siblings('.submissionButton').toggle(); // Toggle the associated post comment button
                            });
                            });



                  // Delegate click events for star rating on dynamic elements
                    $(document).ready(function() {
                        $('.container-allAnswersWithItsComments').on('click', 'label', function() {
                            let clickedIndex = $(this).index() / 2; // Adjusted because each label follows a radio input, doubling the number of children
                            // Store the clicked rating in the parent container
                            $(this).closest('.cont').data('rating', clickedIndex);

                            // Change color of the stars accordingly
                            $(this).closest('.cont').find('label').css('color', function(index) {
                                return index <= clickedIndex ? 'gold' : '#ccc';
                            });
                        });

                        $('.container-allAnswersWithItsComments').on('mouseover', 'label', function() {
                            let hoverIndex = $(this).index() / 2; // Same adjustment for the doubled index count
                            $(this).closest('.cont').find('label').css('color', function(index) {
                                return index <= hoverIndex ? 'gold' : '#ccc';
                            });
                        });

                        $('.container-allAnswersWithItsComments').on('mouseout', '.cont', function() {
                            let storedRating = $(this).data('rating') || -1;  // Default to -1 if no rating has been set
                            $(this).find('label').css('color', function(index) {
                                return index <= storedRating ? 'gold' : '#ccc';
                            });
                        });
                    });




                    // splitting the tags into spans
                    function splitTextIntoSpans(spanId) {
                        var span = document.getElementById(spanId);
                        if (!span) return;

                        var text = span.textContent.trim(); // Get the text content of the span and remove leading/trailing whitespace
                        var tags = text.split(','); // Split the text into an array of tags using commas as separators

                        // Clear the content of the original span
                        span.innerHTML = '';

                        // Iterate over the array of tags and create a new <span> element for each tag
                        tags.forEach(function (tag) {
                            var newSpan = document.createElement('span');
                            newSpan.textContent = tag.trim(); // Set the text content of the new span to the current tag
                            newSpan.classList.add('tag'); // Add the 'tag' class to the new span
                            span.appendChild(newSpan); // Append the new span to the original span
                        });
                    }
                    splitTextIntoSpans("tag");

                    document.addEventListener('DOMContentLoaded', function () {
                        const answerContainers = document.querySelectorAll('.answer');

                        answerContainers.forEach(function (answerContainer) {
                            const stars = answerContainer.querySelectorAll('.cont input[type="radio"]');
                            const labels = answerContainer.querySelectorAll('.cont label[for^="star"]');

                            function updateStars(stars, labels, index) {
                                stars.forEach(function (s, i) {
                                    if (i <= index) {
                                        labels[i].classList.add('gold');
                                    } else {
                                        labels[i].classList.remove('gold');
                                    }
                                });
                            }

                            stars.forEach(function (star, index) {
                                star.addEventListener('mouseenter', function () {
                                    updateStars(stars, labels, index);
                                });

                                star.addEventListener('click', function () {
                                    updateStars(stars, labels, index);
                                });

                                // Remove 'gold' class from all stars on mouseleave
                                star.addEventListener('mouseleave', function () {
                                    labels.forEach(function (label) {
                                        label.classList.remove('gold');
                                    });
                                });
                            });
                        });
                    });


                    document.addEventListener('DOMContentLoaded', function () {
                        const answerContainers = document.querySelectorAll('.cont');

                        answerContainers.forEach(function (answerContainer) {
                            const stars = answerContainer.querySelectorAll('.cont input[type="radio"]');
                            const labels = answerContainer.querySelectorAll('.cont label[for^="star"]');

                            function updateStars(stars, labels, index) {
                                stars.forEach(function (s, i) {
                                    if (i <= index) {
                                        labels[i].classList.add('gold');
                                        s.checked = true; // Check the radio button corresponding to the clicked star
                                    } else {
                                        labels[i].classList.remove('gold');
                                    }
                                });
                            }

                            stars.forEach(function (star, index) {
                                star.addEventListener('mouseenter', function () {
                                    updateStars(stars, labels, index);
                                });

                                star.addEventListener('click', function () {
                                    updateStars(stars, labels, index);
                                });

                                // Remove 'gold' class from all stars on mouseleave
                                star.addEventListener('mouseleave', function () {
                                    // Check if any star is already selected
                                    let selectedIndex = -1;
                                    stars.forEach(function (s, i) {
                                        if (s.checked) {
                                            selectedIndex = i;
                                        }
                                    });

                                    if (selectedIndex === -1) {
                                        // If no star is selected, remove 'gold' class from all labels
                                        labels.forEach(function (label) {
                                            label.classList.remove('gold');
                                        });
                                    } else {
                                        // If a star is selected, update stars up to the selected index
                                        updateStars(stars, labels, selectedIndex);
                                    }
                                });
                            });
                        });
                    });

                </script>       
</body>

</html>