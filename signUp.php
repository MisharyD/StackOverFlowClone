<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "381-project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error message variable
$error_message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $rememberMe = isset($_POST["rememberMe"]) ? 1 : 0;

    // Check if the username or email already exists in the database
    $sql = "SELECT * FROM user WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error_message = "Username or email already exists";
    } else {
        // Insert user into the database
        $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            // Set remember me cookie if checked
            if ($rememberMe) {
                // Set a cookie to remember the user
                setcookie("remember_user", $username, time() + (4 * 24 * 60 * 60), "/"); // Cookie expires in 4 days
            }

            // Redirect to homepage
            $_SESSION["username"] = $username; // Store username in session variable
            header("Location: index.php");
            exit;
        } else {
            $error_message = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign-up</title>
    <link rel="stylesheet" href="CSS/sign-up.css">

</head>



<body>

    <div class="header">
        <div class="logo"> <a href="https://stackoverflow.com">
                <img src="logoSOV.png" alt="logo"></a> <b>StackOverFlow</b></div>
        <div class="SrchBar">
            <form action="mainSearchHandler.php" method="POST">
                <input style="padding-left:15px" type="text" name="searchBar" id="searchBar" placeholder="Search....">
            </form>
        </div>
        <div class="acc"><svg style="color: orange;" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg></div>
        <div class="login"><a href="https://stackoverflow.com" id="login-hover"
                style=" align-items: center; text-decoration: none">Login</a></div>

        <div class="signUp"><a href="https://stackoverflow.com" id="login-hover" style=" display: flex;
    justify-content: center;
    align-items: center;text-decoration: none;">Sign-Up</a></div>
    </div>



    <div class="content">


        <div class="square">

            <div id="errorMSG"></div>

            <div class="logo1"><a href="https://stackoverflow.com">
                    <img src="logoSOV.png" alt="logo"></a></div>


            <div class="main">

                <form id="signUP-form" method="POST">


                    <label for="username">
                        <h4>Username</h4>
                        <input required style="width:100%; height:40px;     width: 100%;
    height: 40px;
    border-radius: 15px;
    border: none;
    border: 1px solid #7f7f7f;
    padding-left:15px;" type="text" name="username" id="username" placeholder="Enter your username....">
                    </label>

                    <label for="email">
                        <h4>Email</h4>
                        <input required style="width:100%; height:40px;     width: 100%;
    height: 40px;
    border-radius: 15px;
    border: none;
    border: 1px solid #7f7f7f;
    padding-left:15px;" type="email" name="email" id="email" placeholder="Enter your email....">
                    </label>

                    <label for="password">
                        <h4>Password</h4>
                        <input required style="width:100%; height:40px;     width: 100%;
    height: 40px;
    border-radius: 15px;
    border: none;
    border: 1px solid #7f7f7f;
    padding-left:15px;" type="password" name="password" id="password" placeholder="Enter your password....">
                    </label>

                    <label for="RbME">
                        <input type="checkbox" name="rememberMe" id="RbME"> Remember Me
                    </label>

                    <div style="display: flex;
    justify-content: center;
    align-items: center;">
                        <button type="submit" class="submit-button">Sign-Up</button>
                    </div>



                </form>

            </div>

            <div class="haveACC"> Already Have An Account? &nbsp&nbsp <a style="text-decoration:none; color:#146aff "
                    href="">Login</a> </div>


        </div>

    </div>


    <script>

        document.getElementById("signUP-form").addEventListener('submit', function (event) {
            var username = document.getElementById("username");
            var password = document.getElementById("password");
            var errorDiv = document.getElementById("errorMSG");

            // Clear previous error messages
            errorDiv.innerHTML = '';

            if (username.value === "" || username.value === null) {
                errorDiv.innerHTML += "Username cannot be empty";
                event.preventDefault();
            }

            if (username.value.indexOf(' ') !== -1) {
                errorDiv.innerHTML += "Username cannot contain spaces";
                event.preventDefault();
            }

            if (password.value.length < 8) {
                errorDiv.innerHTML += "Password must be at least 8 characters long";
                event.preventDefault();
            }


        });

        // // Function to show an alert with the error message
        function showErrorAlert() {
            <?php if (!empty($error_message)): ?>
                var errorDiv = document.getElementById("errorMSG");
                errorDiv.innerHTML = "<?php echo $error_message; ?>";
            <?php endif; ?>
        }
        // // Call showErrorAlert() function when the page loads
        window.onload = function () {
            showErrorAlert();
        };





    </script>


</body>

</html>
