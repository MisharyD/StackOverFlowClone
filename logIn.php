<?php

include "loginHandler.php"

  ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="CSS/login.css">
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
    <div class="login"><a href="https://stackoverflow.com" id="login-hover" style=" display: flex;
    justify-content: center;
    align-items: center; text-decoration: none">Login</a></div>

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

        <form id="log-form" method="POST">


          <label for="username">
            <h4>Username</h4>
            <input required style="width:100%; height:40px;     width: 100%;
    height: 40px;
    border-radius: 15px;
    border: none;
    border: 1px solid #7f7f7f;
    padding-left:15px;" type="text" name="username" id="username" placeholder="Enter your username....">
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
            <button type="submit" class="submit-button">Login</button>
          </div>



        </form>

      </div>

      <div class="dont-haveACC"> Don't Have An Account ?&nbsp&nbsp <a style="text-decoration:none; color:#146aff "
          href="">Sign-Up</a> </div>


    </div>

  </div>



  <script>

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

  <!-- <script src="/TMPLearning/JS/j1.js"></script> -->
</body>

</html>
