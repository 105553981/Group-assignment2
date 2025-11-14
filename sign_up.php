<?php
include("header.inc");
require_once("settings.php");

$conn = mysqli_connect($host, $user, $pass, $db);

// Get form data
$username = trim($_POST['username']);
$password = trim($_POST['password']);
// Insert user into the database
$query = "INSERT INTO staff (username, password) VALUES ('$username', '$password')";
$result = mysqli_query($conn, $query);

if ($result) {
  echo "✅ Signup successful. You can now <a href='sign_in.php'>login</a>.";
} else {
  echo "❌ Signup failed. Please try again.";
}
include("footer.inc");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign up</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>

<body>

  <form method="post" action="sign_up.php">
    <section class="back-G">
      <h1 class="h1"><span class="highlight">Webtech</span> staff Login Page</h1>

      <!-- Job Application -->
      <section class="apply-box">
        <div class="form-header">
          <img class="form-logo" src="images/logo.png" alt="Webtech Logo">
          <hr>
          <h3 id="header-text">Sign up Form</h3>
        </div>
        <hr style="margin-top: 20px;" ;>
        <div class="wrap_form" style="display: flex;">
          <!-- Username -->
          <div class="user_password_input">
            <h4 class="form-heading">Username</h4>
            <label for="username" class="highlight"><strong>Typing your username</strong></label>
            <input type="text" pattern="[a-zA-Z]+" name="username" id="username" maxlength="20" size="30">

            <!-- Password -->
            <h4 class="form-heading">Password</h4>
            <label for="last-name" class="highlight"><strong>Enter your password</strong></label>
            <input type="password" style="margin-left: 8px;" pattern="[a-zA-Z]+" name="password" id="password"
              maxlength="20" size="30">
          </div>
          <div class="form_image">
            <img src="images/admin.png" style="width: 60%; margin-left: 110px; margin-top: 58px;">
          </div>
        </div>

        <!-- Button -->
        <input type="submit" id="submit-button" value="Sign up"
          style="margin-left: 10px; padding-left: 90px; padding-right: 153px;">
        </div>
      </section>
    </section>


    </div>
    </div>
  </form>
</body>

</html>