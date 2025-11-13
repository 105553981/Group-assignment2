<?php
  $current_page = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="logo-nav">
        <a href="index.php">
          <img class="logo" src="images/logo.png" alt="WebTech Logo">
        </a>
      </div>

      <ul class="nav-links">
        <li><a href="index.php" class="navbar-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Home</a></li>
        <li><a href="about.php" class="navbar-item <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>">About</a></li>
        <li><a href="apply.php" class="navbar-item <?php echo ($current_page == 'apply.php') ? 'active' : ''; ?>">Apply</a></li>
        <li><a href="jobs.php" class="navbar-item <?php echo ($current_page == 'jobs.php') ? 'active' : ''; ?>">Job Descriptions</a></li>
        <li><a href="mailto:info@webtech.com.au" class="navbar-item">Contact Us</a></li>
      </ul>
    </nav>
  </header>
