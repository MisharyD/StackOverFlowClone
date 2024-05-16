<?php
session_start();

if (!isset($_SESSION["username"]) && !isset($_COOKIE["remember_user"])) {
    header("Location: signIn.php");
    exit();
}

include ("database.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data
    $questionTitle = mysqli_real_escape_string($conn, $_POST["questionTitle"]);
    $questionDescription = mysqli_real_escape_string($conn, $_POST["questionDescription"]);
    $questionTags = mysqli_real_escape_string($conn, $_POST["questionTags"]);
    $username = $_SESSION["username"];

    // Check if a question with the same title already exists
    $checkSql = "SELECT * FROM question WHERE title = '$questionTitle'";
    $result = mysqli_query($conn, $checkSql);
    if (mysqli_num_rows($result) > 0) {
        // Question with the same title already exists, redirect to question.php with the existing question's title
        $_SESSION['thereIs'] = "Hi $username, this question same as yours";
        header("Location: question.php?qat=$questionTitle");
        exit();
    } else {
        // Insert the form data into the database with CURRENT_TIMESTAMP() for the created_at column
        $sql = "INSERT INTO question (userName, title, description, created_at) 
                VALUES ('$username', '$questionTitle', '$questionDescription', CURRENT_TIMESTAMP())";

        if (mysqli_query($conn, $sql)) {
            // Get the ID of the inserted question
            $question_id = mysqli_insert_id($conn);

            // Insert tags into the tag table
            $tags = explode(',', $questionTags); // Assuming tags are separated by commas
            foreach ($tags as $tag) {
                $tag = trim($tag); // Trim whitespace
                $tag = mysqli_real_escape_string($conn, $tag); // Escape tag
                // Insert tag into tag table
                $tagSql = "INSERT INTO tag (question_id, tagName) VALUES ('$question_id', '$tag')";
                mysqli_query($conn, $tagSql);
            }

            // Redirect to a success page or do something else if the insertion is successful
            header("Location: index.php");
            exit();
        } else {
            // Handle the case where insertion fails
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Question</title>
    <link rel="stylesheet" href="styles/test.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/createQuestion.css">
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
                <h1>Ask a question</h1>
                <div class="container">
                    <div class="right-side">
                        <form action="createQuestion.php" method="POST">
                            <label for="questionTitle">Title:</label>
                            <input type="text" id="questionTitle" name="questionTitle" required><br><br>

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
</body>

</html>
