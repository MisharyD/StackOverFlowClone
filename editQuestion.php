<?php
session_start();

if (!isset($_SESSION["username"]) && !isset($_COOKIE["remember_user"])) {
    header("Location: signIn.php");
    exit();
}

include ("database.php");

if (isset($_GET['qat'])) 
{
    $questionTitle = htmlspecialchars($_GET['qat']);
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
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data
    $newQuestionTitle = mysqli_real_escape_string($conn, $_POST["questionTitle"]);
    $newQuestionDescription = mysqli_real_escape_string($conn, $_POST["questionDescription"]);
    $newQuestionTags = mysqli_real_escape_string($conn, $_POST["questionTags"]);
    $username = $_SESSION["username"];

    // Check if the new question title already exists
    $checkSql = "SELECT * FROM question WHERE title = '$newQuestionTitle'";
    $checkResult = mysqli_query($conn, $checkSql);
    if (mysqli_num_rows($checkResult) > 0 && $newQuestionTitle != $_POST['qat']) {
        // If the new title exists already
        header("Location: question.php?qat=" . urlencode($newQuestionTitle));
        exit();
    }

        $updateSql = "UPDATE question SET title = '$newQuestionTitle', description = '$newQuestionDescription' WHERE title = '{$_POST['qat']}' ";
        if (!mysqli_query($conn, $updateSql)) {
            throw new Exception(mysqli_error($conn));
        }

        // Delete existing tags associated with the question
        $deleteTagsSql = "DELETE FROM tag WHERE question_id IN (SELECT question_id FROM question WHERE title = '$newQuestionTitle')";
        if (!mysqli_query($conn, $deleteTagsSql)) {
            throw new Exception(mysqli_error($conn));
        }

        // Insert the new tags into the tag table
        $tags = explode(',', $newQuestionTags); // Assuming tags are separated by commas
        foreach ($tags as $tag) {
            $tag = trim($tag); // Trim whitespace
            $tag = mysqli_real_escape_string($conn, $tag); // Escape tag
            // Insert tag into tag table
            $tagInsertSql = "INSERT INTO tag (question_id, tagName) SELECT question_id, '$tag' FROM question WHERE title = '$newQuestionTitle'";
            if (!mysqli_query($conn, $tagInsertSql)) {
                throw new Exception(mysqli_error($conn));
            }
        }

        // Update session status and redirect
        $_SESSION['editQuestionStatus'] = "Question edited successfully";
        header("Location: userHome.php");
        exit();
    }   

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <!-- <link rel="stylesheet" href="styles/test.css"> -->
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/createQuestion.css">

    <style>
        .prevQ {
            background-color: #f7f6f6;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 70px;
        }

        .tag {
            font-size: 0.8em;
            align-self: flex-end;
            color: hsla(210, 77%, 36%, 1);
            background-color: hsla(210, 80%, 93%, 1);
            /* margin-right: 5pt; */
            padding: 4px;
            font-size: 12PX;
            FONT-WEIGHT: BOLD;
        }

        #tag {
            display: flex;
            justify-content: space-between;
            width: fit-content;

        }



        .question-content-tag {
            display: flex;
            align-self: flex-end;
        }
    </style>
</head>

<body>
    <!-- Header part-->
    <?php
    include "LoggedIn-header.php";
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
                <div class="container">
                    <div class="right-side">


                        <div class="question-container">
                            <div class="question-header">
                                <div class="prevQ">


                                    <h1 class="question-title" id="Qtitle"><?php echo $questionTitle ?></h1>
                                    <h6 class="question-description" id="Qdescription"><?php echo $description ?></h6>

                                    <!-- <span class="tags-container"> -->
                                    <span class="tag" id="tag"><?php echo $tag ?></span>
                                    <!-- </span> -->
                                </div>

                                <form class = ".editQuestion" action="editQuestion.php" method="post">
                                    <h1>Edit question</h1>
                                    <label for="questionTitle">Title:</label>
                                    <input type="text" id="questionTitle" name="questionTitle" required><br><br>

                                    <input type="hidden" name="qat" value = "<?php echo $questionTitle ?>" > 
                                    

                                    <label for="questionDescription">Description:</label><br>
                                    <textarea id="questionDescription" name="questionDescription" rows="4" cols="50"
                                        required></textarea><br><br>

                                    <label for="questionTags">Tags:</label>
                                    <input type="text" id="questionTags" name="questionTags"><br><br>

                                    <input type="submit" value="Submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script>
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

            </script>

</body>

</html>