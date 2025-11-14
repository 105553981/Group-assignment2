<?php
$page_title = "Job Descriptions";
include_once("header.inc");
include_once("settings.php");
$conn = @mysqli_connect($host, $user, $pass, $db);

// Tạo kết nối
$conn = new mysqli($host, $user, $pass, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Set charset để hiển thị tiếng Việt (nếu có)
$conn->set_charset("utf8mb4");

// 1. Lấy tất cả dữ liệu công việc từ DB
$sql = "SELECT * FROM jobs ORDER BY job_id ASC";
$result = $conn->query($sql);

// 2. Lưu kết quả vào một mảng (array) để dễ dàng tái sử dụng
$jobs = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $jobs[] = $row; // Thêm mỗi dòng (công việc) vào mảng $jobs
  }
}
// === KẾT THÚC PHẦN KẾT NỐI ===
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
        $count = 0; // Biến đếm để ngắt dòng
        foreach ($jobs as $job) {
          // Hiển thị hộp tóm tắt cho mỗi công việc
          echo '<div class="short-description-box">';
          echo '  <img class="job-emoji" src="' . htmlspecialchars($job['image_path']) . '" alt="' . htmlspecialchars($job['image_alt']) . '">';
          echo '  <h3 class="box-title">' . htmlspecialchars($job['title']) . '</h3>';
          echo '  <p>Salary range: ' . htmlspecialchars($job['salary']) . '</p>';
          echo '  <p>' . htmlspecialchars($job['experience_summary']) . '</p>';
          echo '  <a href="#' . htmlspecialchars($job['anchor_id']) . '" class="show-button">Explore Now</a>';
          echo '</div>';

          $count++;

          // Sau 3 công việc, đóng thẻ div của line 1 và mở thẻ div cho line 2
          if ($count == 3) {
            echo '</div>'; // Đóng summarise-job-line1
            echo '<div class="summarise-job-line2">'; // Mở summarise-job-line2
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
          // Định dạng lại ngày tháng
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
                <?php echo $job['responsibilities']; // Echo trực tiếp HTML (các thẻ <li>) ?>
                </ol>
              <p><strong>Required Qualifications, Skills, Knowledge, and Attributes:</strong></p>
              <p><strong>Essential:</strong></p>
              <ul>
                <?php echo $job['essential']; // Echo trực tiếp HTML (các thẻ <li>) ?>
                </ul>
              <p><strong>Preferable:</strong></p>
              <ul>
                <?php echo $job['preferable']; // Echo trực tiếp HTML (các thẻ <li>) ?>
                </ul>
              </div>
            </div>
          <?php
        } // Kết thúc vòng lặp foreach
      } // Kết thúc if
      ?>

    </div>
  </section>
</body>

</html>
<?php
$conn->close(); // Đóng kết nối database
include_once("footer.inc");
?>