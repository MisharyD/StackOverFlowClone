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
    $newAnswerDescription = mysqli_real_escape_string($conn, $_POST["answerDescription"]);

    // Update the answer description
    $updateSql = "UPDATE answer SET description = '$newAnswerDescription' WHERE question_id = '{$_POST['qat']}' AND userName = '{$_SESSION["username"]}'";
    if (!mysqli_query($conn, $updateSql)) {
        throw new Exception(mysqli_error($conn));
    }

    // Redirect to userHome.php after updating the answer
    $_SESSION['editAnswerStatus'] = "Answer edited successfully";
    header("Location: userHome.php");
    exit();
}

// Assuming you have the description and created_at from the GET parameters
if (isset($_GET['description']) && isset($_GET['created_at'])) {
    $answerDescription = htmlspecialchars($_GET['description']);
    $createdAt = htmlspecialchars($_GET['created_at']);

    // Fetch question details based on answer information
    $questionInfoQuery = "SELECT q.question_id, q.userName AS question_username, q.title, q.description AS question_description, q.created_at AS question_created_at, IFNULL(GROUP_CONCAT(t.tagName SEPARATOR ', '), 'None') AS tag
                        FROM question q
                        LEFT JOIN tag t ON q.question_id = t.question_id
                        WHERE q.question_id = (SELECT question_id FROM answer WHERE description = '$answerDescription' AND created_at = '$createdAt')";
    $questionInfoResult = mysqli_query($conn, $questionInfoQuery);

    // Check if any rows were returned
    if ($row = mysqli_fetch_assoc($questionInfoResult)) {
        // Store question details in variables
        $question_id = $row["question_id"];
        $questionTitle = $row["title"];
        $questionDescription = $row["question_description"];
        $questionCreatedAt = $row["question_created_at"];
        $username = $row["question_username"];
        $tag = $row["tag"];
    } else {
        echo "Question not found.";
        exit();
    }
} else {
    echo "Answer description and created_at not provided.";
    exit();
}

// Get the previous answer description
$prevAnswerQuery = "SELECT description FROM answer WHERE question_id = '$question_id' AND userName = '{$_SESSION["username"]}'";
$prevAnswerResult = mysqli_query($conn, $prevAnswerQuery);
if ($prevAnswerRow = mysqli_fetch_assoc($prevAnswerResult)) {
    $prevAnswerDescription = $prevAnswerRow["description"];
} else {
    $prevAnswerDescription = "";
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Answer</title>
    <link rel="stylesheet" href="styles/test.css">
    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/header.css">

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
            padding: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        #tag {
            display: flex;
            justify-content: space-between;
            width: fit-content;

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
                                <h1>You answered this question</h1>
                                <div class="prevQ">
                                    <h1 class="question-title" id="Qtitle"><?php echo $questionTitle ?></h1>
                                    <h6 class="question-description" id="Qdescription">
                                        <?php echo $questionDescription ?></h6>
                                    <span class="tag" id="tag"><?php echo $tag ?></span>
                                </div>

                                <h1>Your previous answer</h1>
                                <div class="prevAns">
                                    <div class="prevDesc"><?php echo $prevAnswerDescription ?></div>
                                </div>

                                <form action="editAnswer.php" method="POST">
                                    <h1>Edit Answer</h1>
                                    <label for="answerDescription">Description:</label><br>
                                    <input type="hidden" name="qat" value = "<?php echo $question_id ?>" > 
                                    <textarea id="answerDescription" name="answerDescription" rows="4" cols="50"
                                        required></textarea><br><br>
                                    <input type="submit" value="Submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>