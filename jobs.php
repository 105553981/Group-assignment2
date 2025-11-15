<?php
$page_title = "Job Descriptions";
include_once("header.inc");
include_once("settings.php");
$conn = @mysqli_connect($host, $user, $pass, $db);


$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$conn->set_charset("utf8mb4");


$sql = "SELECT * FROM jobs ORDER BY job_id ASC";
$result = $conn->query($sql);


$jobs = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $jobs[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="en">


<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Descriptions</title>

  <link rel="stylesheet" href="styles/styles.css">

</head>

<body>

  <section class="back-G">
    <h1 class="h1">Job Descriptions</h1>
    <h2 class="h2">Lists of jobs at Webtech</h2>

    <div class="summarise-job-line1">
      <?php
      if (!empty($jobs)) {
        $count = 0;
        foreach ($jobs as $job) {
          echo '<div class="short-description-box">';
          echo '  <img class="job-emoji" src="' . htmlspecialchars($job['image_path']) . '" alt="' . htmlspecialchars($job['image_alt']) . '">';
          echo '  <h3 class="box-title">' . htmlspecialchars($job['title']) . '</h3>';
          echo '  <p>Salary range: ' . htmlspecialchars($job['salary']) . '</p>';
          echo '  <p>' . htmlspecialchars($job['experience_summary']) . '</p>';
          echo '  <a href="#' . htmlspecialchars($job['anchor_id']) . '" class="show-button">Explore Now</a>';
          echo '</div>';

          $count++;


          if ($count == 3) {
            echo '</div>';
            echo '<div class="summarise-job-line2">';
          }
        }
      } else {
        echo "<p>No job listings found.</p>";
      }
      ?>

    </div>   <div class="jobs-list">
      <?php
      if (!empty($jobs)) {
        foreach ($jobs as $job) {
          $posted_date_formatted = date("F jS, Y", strtotime($job['posted_date']));
          ?>
          <div id="<?php echo htmlspecialchars($job['anchor_id']); ?>" class="job-detail">
            <h3 class="job-title"><strong><?php echo htmlspecialchars($job['title']); ?></strong></h3>
            <div class="description-text">
              <aside class="job-aside">
                <p><strong>Job Reference Number: <?php echo htmlspecialchars($job['job_ref']); ?></strong></p>
                <p>Posted on:</p>
                <p><?php echo $posted_date_formatted; ?></p>
                <p>Location: <?php echo htmlspecialchars($job['location']); ?></p>
                <p>Salary range:</p>
                <p><?php echo htmlspecialchars($job['salary']); ?></p>
                <p>Contact our HR Department at: <a
                    href="mailto:<?php echo htmlspecialchars($job['contact_email']); ?>"><?php echo htmlspecialchars($job['contact_email']); ?></a>
                </p>
                <div class="apply-link-button">
                  <p class="colortext-button"><a href="apply.php">Apply Now</a></p>
                  </div>
                </aside>

              <p><strong>Brief Description of the Position:</strong>
                <?php echo htmlspecialchars($job['description']); ?>
                </p>
              <p><strong>Reports To:</strong> <?php echo htmlspecialchars($job['reports_to']); ?></p>
              <p><strong>Key Responsibilities:</strong></p>
              <ol>
                <?php echo $job['responsibilities']; ?>
                </ol>
              <p><strong>Required Qualifications, Skills, Knowledge, and Attributes:</strong></p>
              <p><strong>Essential:</strong></p>
              <ul>
                <?php echo $job['essential'];  ?>
                </ul>
              <p><strong>Preferable:</strong></p>
              <ul>
                <?php echo $job['preferable'];  ?>
                </ul>
              </div>
            </div>
          <?php
        }
      }
      ?>

    </div>
  </section>
</body>

</html>
<?php
$conn->close();
include_once("footer.inc");
?>