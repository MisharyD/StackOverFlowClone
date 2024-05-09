<?php

include "signUpHandler.php"

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sign-up</title>
    <link rel="stylesheet" href="styles/sign-up.css">

</head>



<body>

<?php include ("header.php"); ?>
    <div class="content">


        <div class="square">

            <div id="errorMSG"></div>

            <div class="logo1"><a href="https://stackoverflow.com">
                    <img src="images/stack.png" alt="logo"></a></div>


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