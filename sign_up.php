<?php
session_start();
include("header.inc");
require_once("settings.php");

$conn = mysqli_connect($host, $user, $pass, $db);
$message = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {


  $username = trim($_POST['username'] ?? '');
  $password = trim($_POST['password'] ?? '');


  if (empty($username) || empty($password)) {
    $message = "❌ Have to enter both Username and Password.";
  } else {

    $clean_username = mysqli_real_escape_string($conn, $username);
    $clean_password = mysqli_real_escape_string($conn, $password);

    // Check if the username exists
    $check_query = "SELECT * FROM staff WHERE username = '$clean_username'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
      $message = "❌ Username already exists. Try another.";
    } else {
      $hash_password = password_hash($clean_password, PASSWORD_DEFAULT);
      $query = "INSERT INTO staff (username, password) VALUES ('$clean_username', '$hash_password')";
      $result = mysqli_query($conn, $query);

      if ($result) {
        $message = "✅ Signup successful. You can now <a href='sign_in.php'>login</a>.";
      } else {
        $message = "❌ Signup failed. This username is already taken.";
      }
    }
  }


}


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

      <section class="apply-box">
        <div class="form-header">
          <img class="form-logo" src="images/logo.png" alt="Webtech Logo">
          <hr>
          <h3 id="header-text">Sign up Form</h3>
        </div>

        <?php if (!empty($message)): ?>
          <p
            style="text-align: center; font-weight: bold; padding: 10px; color: <?php echo (strpos($message, '✅') !== false) ? 'green' : 'red'; ?>;">
            <?php echo $message; ?>
          </p>
        <?php endif; ?>

        <hr style="margin-top: 20px;" ;>
        <div class="wrap_form" style="display: flex;">
          <div class="user_password_input">
            <h4 class="form-heading">Username</h4>
            <label for="username" class="highlight"><strong>Typing your username</strong></label>
            <input type="text" pattern="[a-zA-Z]+" name="username" id="username" maxlength="20" size="30" required>

            <h4 class="form-heading">Password</h4>
            <label for="password" class="highlight"><strong>Enter your password</strong></label>
            <input type="password" style="margin-left: 8px;" pattern="[a-zA-Z]+" name="password" id="password"
              maxlength="20" size="30" required>
          </div>
          <div class="form_image">
            <img src="images/admin.png" style="width: 60%; margin-left: 110px; margin-top: 58px;">
            <!-- Image source: https://www.flaticon.com/free-icon/admin_2206368 -->
          </div>
        </div>

        <input type="submit" id="submit-button" value="Sign up"
          style="margin-left: 10px; padding-left: 90px; padding-right: 153px;">
        </div>
      </section>
    </section>
  </form>
</body>

</html>

<?php
include("footer.inc");
?>