<?php
// Yêu cầu A8: Bạn có thể thêm logic kiểm tra đăng nhập (username/password) ở đây
// session_start();
// if (!isset($_SESSION['manager_logged_in'])) {
//    header('Location: login.php'); // Trang đăng nhập tự tạo
//    exit();
// }

$page_title = "Manage EOIs";
include_once("header.inc");
require_once("settings.php"); // Cần để kết nối CSDL
?>

<head>
  <title><?php echo $page_title; ?></title>
</head>

<section class="back-G">
  <h1 class="h1">HR Management Portal</h1>

  <div class="apply-box">
    <h3 class="form-heading">Search & Manage EOIs</h3>
    <hr class="end-line-heading">

    <form method="get" action="manage.php">

      <legend class="highlight" style="font-size: 20px;"><strong>List All EOIs</strong></legend>
      <p style="font-size:20px;">List all current Expressions of Interest.
        <input type="submit" name="list_all" value="List All"
          onmouseover="this.style.backgroundColor='green'; this.style.color='black';"
          onmouseout="this.style.backgroundColor='black'; this.style.color='white';" style="padding-left: 10px; padding-right: 10px; background-color:black; color: white;
    ">
      </p>

    </form>
    <hr class="end-line-heading">

    <form method="get" action="manage.php">

      <legend class="highlight" style="font-size: 20px;"><strong>List by Job Reference</strong></legend>
      <label for="job_ref_search">Job Reference Number:</label>
      <input type="text" name="job_ref_search" id="job_ref_search">
      <input type="submit" value="Search by Job Ref"
        onmouseover="this.style.backgroundColor='green'; this.style.color='black';"
        onmouseout="this.style.backgroundColor='black'; this.style.color='white';" style="padding-left: 10px; padding-right: 10px; background-color:black; color: white;>

    </form>
    <hr class=" end-line-heading">

      <form method="get" action="manage.php">

        <legend class="highlight" style="font-size: 20px;"><strong>List by Applicant Name</strong></legend>
        <label for="first_name_search">First Name:</label>
        <input type="text" name="first_name_search" id="first_name_search">
        <label for="last_name_search">Last Name:</label>
        <input type="text" name="last_name_search" id="last_name_search">
        <p>(Leave one blank to search by first or last name only)</p>
        <input type="submit" value="Search by Name"
          onmouseover="this.style.backgroundColor='green'; this.style.color='black';"
          onmouseout="this.style.backgroundColor='black'; this.style.color='white';" style="padding-left: 10px; padding-right: 10px; background-color:black; color: white;>

    </form>
    <hr class=" end-line-heading">

        <form method="post" action="manage.php">

          <legend class="highlight" style="font-size: 20px;"><strong>Delete by Job Reference</strong></legend>
          <label for="job_ref_delete">Job Reference Number:</label>
          <input type="text" name="job_ref_delete" id="job_ref_delete">

          <input type="submit" value="Delete All"
            onmouseover="this.style.backgroundColor='green'; this.style.color='black';"
            onmouseout="this.style.backgroundColor='black'; this.style.color='white';" style="padding-left: 10px; padding-right: 10px; background-color:black; color: white;
    ">

        </form>
        <hr class="end-line-heading">

        <form method="post" action="manage.php">

          <legend class="highlight" style="font-size: 20px;"><strong>Change EOI Status</strong></legend>
          <label for="eoi_num_update">EOI Number:</label>
          <input type="text" name="eoi_num_update" id="eoi_num_update">

          <label for="new_status">New Status:</label>
          <select name="new_status" id="new_status">
            <option value="New">New</option>
            <option value="Current">Current</option>
            <option value="Final">Final</option>
          </select>
          <input type="submit" value="Update Status"
            onmouseover="this.style.backgroundColor='green'; this.style.color='black';"
            onmouseout="this.style.backgroundColor='black'; this.style.color='white';" style="padding-left: 10px; padding-right: 10px; background-color:black; color: white;>

    </form>
  </div>

  <div class=" apply-box" style="margin-top: 30px;">
          <h3 class="form-heading">Query Results</h3>
          <hr class="end-line-heading">
          <div id="results-container" style="overflow-x: auto;">
            <?php
            // === LOGIC XỬ LÝ KẾT QUẢ TRUY VẤN SẼ NẰM Ở ĐÂY ===
            
            $conn = @mysqli_connect($host, $user, $pass, $db);
            if ($conn) {

              // BẠN CẦN VIẾT LOGIC CHO TỪNG FORM
              // Ví dụ cho "List All"
              if (isset($_GET['list_all'])) {
                $sql = "SELECT * FROM eoi";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                  echo "<table border='1' style='width: 100%; border-collapse: collapse;'>";
                  echo "<thead><tr><th>EOI</th><th>Job Ref</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th></tr></thead>";
                  echo "<tbody>";
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['EOInumber']}</td>";
                    echo "<td>{$row['job_ref_num']}</td>";
                    echo "<td>{$row['first_name']} {$row['last_name']}</td>";
                    echo "<td>{$row['email']}</td>";
                    echo "<td>{$row['phone']}</td>";
                    echo "<td>{$row['status']}</td>";
                    echo "</tr>";
                  }
                  echo "</tbody></table>";
                  mysqli_free_result($result);
                } else {
                  echo "<p>No EOIs found.</p>";
                }
              }

              // (Bạn cần tự viết logic cho các form GET và POST khác:
              // - $_GET['job_ref_search']
              // - $_GET['first_name_search'] / $_GET['last_name_search'] (nhớ dùng LIKE %...%)
              // - $_POST['job_ref_delete'] (dùng DELETE FROM...)
              // - $_POST['eoi_num_update'] / $_POST['new_status'] (dùng UPDATE ... SET status = ? WHERE EOInumber = ?)
            
              mysqli_close($conn);
            } else {
              echo "<p>Database connection failure.</p>";
            }
            ?>
          </div>
  </div>
</section>

<?php
include_once("footer.inc"); // Thêm footer
?>