<?php
$page_title = "Manage EOIs";
include_once("header.inc");
require_once("settings.php");
?>
<section class="back-G">
  <h1 class="h1">HR Management Portal</h1>
  <form action="logout.php" method="post">
    <input type="submit" value="Logout" style="
            margin-left: 46%;
            padding: 25px;
            margin-top: 30px;
            font-size: 20px;
            background-color: black;
            color: white;
            border-radius: 10px;
            cursor: pointer;" onmouseover="this.style.backgroundColor='green'; this.style.color='black';"
      onmouseout="this.style.backgroundColor='black'; this.style.color='white';">
  </form>
</section>


<div class="apply-box">
  <h3 class="form-heading">Search & Manage EOIs</h3>
  <hr class="end-line-heading">
  <!--HTML of List all EOIs -->
  <form method="get" action="manage.php#result">

    <legend class="highlight" style="font-size: 20px;"><strong>List All EOIs</strong></legend>
    <p style="font-size:20px;">List all current Expressions of Interest.
      <input type="submit" name="list_all" value="List All"
        onmouseover="this.style.backgroundColor='green'; this.style.color='black';"
        onmouseout="this.style.backgroundColor='black'; this.style.color='white';" style="padding-left: 10px; padding-right: 10px; background-color:black; color: white;
    ">
    </p>

  </form>
  <hr class="end-line-heading">
  <!-- HTML List by Job reference number -->
  <form method="get" action="manage.php#show-job-ref">

    <legend class="highlight" style="font-size: 20px;"><strong>List by Job Reference</strong></legend>

    <label for="job_ref_search">Job Reference Number:</label>
    <input type="text" name="job_ref_search" id="job_ref_search">

    <input type="submit" value="Search by Job Ref"
      style="padding-left:10px; padding-right:10px; background-color:black; color:white;"
      onmouseover="this.style.backgroundColor='green'; this.style.color='black';"
      onmouseout="this.style.backgroundColor='black'; this.style.color='white';">
  </form>
  <hr class=" end-line-heading">
  <!-- HTML Show by first/last name or both -->
  <form method="get" action="manage.php#show-name">

    <legend class="highlight" style="font-size: 20px;"><strong>List by Applicant Name</strong></legend>
    <label for="first_name_search">First Name:</label>
    <input type="text" name="first_name_search" id="first_name_search">
    <label for="last_name_search">Last Name:</label>
    <input type="text" name="last_name_search" id="last_name_search">
    <p>(Leave one blank to search by first or last name only)</p>
    <input type="submit" value="Search by Name"
      onmouseover="this.style.backgroundColor='green'; this.style.color='black';"
      onmouseout="this.style.backgroundColor='black'; this.style.color='white';"
      style="padding-left: 10px; padding-right: 10px; background-color:black; color: white;">


  </form>
  <hr class=" end-line-heading">
  <!-- HTML Delete one all records of one Job reference number -->
  <form method="post" action="manage.php#delete">

    <legend class="highlight" style="font-size: 20px;"><strong>Delete by Job Reference</strong></legend>
    <label for="job_ref_delete">Job Reference Number:</label>
    <input type="text" name="job_ref_delete" id="job_ref_delete">

    <input type="submit" value="Delete All" onmouseover="this.style.backgroundColor='green'; this.style.color='black';"
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
      onmouseout="this.style.backgroundColor='black'; this.style.color='white';"
      style="padding-left: 10px; padding-right: 10px; background-color:black; color: white;">

  </form>
</div>

<div class="apply-box" style="margin-top: 30px;">
  <h3 class="form-heading">Query Results</h3>
  <hr class="end-line-heading">
  <div id="results-container" style="overflow-x: auto;">
    <!-- PHP -->
    <?php

    $conn = @mysqli_connect($host, $user, $pass, $db);
    if ($conn) {

      echo "<a id='result'></a>";

      // List all
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
      // Search using Job reference number
      if (!empty($_GET['job_ref_search'])) {
        $job_ref = mysqli_real_escape_string($conn, $_GET['job_ref_search']);

        echo "<a id='show-job-ref'></a>";
        // SQL command
        $sql = "SELECT * FROM eoi WHERE job_ref_num = '$job_ref'";
        $result = mysqli_query($conn, $sql);

        echo "<h3>Applicants for Job Reference: <span style='color:red;'>$job_ref</span></h3>";


        if ($result && mysqli_num_rows($result) > 0) {
          echo "<table border='1' style='width: 100%; border-collapse: collapse;'>";
          echo "<thead>
                <tr>
                  <th>EOI</th>
                  <th>Job Ref</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Skills</th>
                  <th>Status</th>
                </tr>
              </thead><tbody>";

          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['EOInumber']}</td>";
            echo "<td>{$row['job_ref_num']}</td>";
            echo "<td>{$row['first_name']}</td>";
            echo "<td>{$row['last_name']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['phone']}</td>";
            echo "<td>{$row['skills']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "</tr>";
          }

          echo "</tbody></table>";

        } else {
          echo "<p>No applicants found for this job reference.</p>";
        }
      }

      // ----- Search by first name / last name -----
      if (isset($_GET['first_name_search']) || isset($_GET['last_name_search'])) {


        $first = trim($_GET['first_name_search']);
        $last = trim($_GET['last_name_search']);

        echo "<a id='show-name'></a>";
        // Check if the first or last variables are empty string.
        if ($first === '' && $last === '') {
          echo "<p style='font-size: 20px; color: red;'>Please enter at least one name to search.</p>";
        } else {
          // Create a "where" array
          $where = [];

          if ($first !== '') {
            $where[] = "first_name LIKE '%$first%'";
          }
          if ($last !== '') {
            $where[] = "last_name LIKE '%$last%'";
          }

          // Combine conditions using "AND"
          $where_sql = implode(" AND ", $where);

          // SQL command
          $sql = "SELECT * FROM eoi WHERE $where_sql";

          $result = mysqli_query($conn, $sql);

          if ($result && mysqli_num_rows($result) > 0) {
            echo "<table border='1' style='width: 100%; border-collapse: collapse;'>";
            echo "<thead>
                <tr>
                  <th>EOI</th>
                  <th>Job Ref</th>
                  <th>First Name</th>
                  <th>Last Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Skills</th>
                  <th>Status</th>
                </tr>
              </thead><tbody>";

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

            echo "</table>";
          } else {
            echo "<p>No matching EOIs found.</p>";
          }
        }
      }
      // Delete Job Reference Number
      if (isset($_POST['job_ref_delete'])) {

        $delete_jrn = trim($_POST['job_ref_delete']);
        echo "<a id='delete'></a>";
        if ($delete_jrn === '') {
          echo "<p>Please enter a Job Reference Number to delete.</p>";
        } else {
          $sql = "DELETE FROM eoi WHERE job_ref_num = '$delete_jrn'";
          $result = mysqli_query($conn, $sql);

          if ($result) {
            $rows_deleted = mysqli_affected_rows($conn);

            if ($rows_deleted > 0) {
              echo "<p>Deleted $rows_deleted record(s) with Job Reference: $delete_jrn.</p>";
            } else {
              echo "<p>No records found with Job Reference: $delete_jrn.</p>";
            }
          } else {
            echo "<p>Error deleting records.</p>";
          }
        }
      }
      // EOI update status Feature
      if (isset($_POST['eoi_num_update']) && isset($_POST['new_status'])) {

        $eoi_num = trim($_POST['eoi_num_update']);
        $new_status = trim($_POST['new_status']);

        // Check if EOI number is empty
        if ($eoi_num === '') {
          echo "<p>Please enter an EOI Number.</p>";
        } else {
          // SQL command
          $sql = "UPDATE eoi SET status = '$new_status' WHERE EOInumber = '$eoi_num'";
          $result = mysqli_query($conn, $sql);

          if ($result) {
            $rows_updated = mysqli_affected_rows($conn);

            if ($rows_updated > 0) {
              echo "<p>EOI #$eoi_num status updated to '$new_status'.</p>";
            } else {
              echo "<p>No EOI found with number $eoi_num.</p>";
            }
          } else {
            echo "<p>Error updating EOI status.</p>";
          }
        }
      }
      mysqli_close($conn);
    } else {
      echo "<p>Database connection failure.</p>";
    }
    ?>
  </div>
</div>
</section>

<?php
include_once("footer.inc");
?>