<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();


if ($_SERVER["REQUEST_METHOD"] != "POST") {
  header("Location: apply.php");
  exit();
}

require_once("settings.php");

$errors = [];
$data = [];


function sanitize_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function validate_postcode($state, $postcode): bool|int
{
  switch ($state) {
    case 'VIC':
      return preg_match('/^(3|8)\d{3}$/', $postcode);
    case 'NSW':
      return preg_match('/^(1|2)\d{3}$/', $postcode);
    case 'QLD':
      return preg_match('/^(4|9)\d{3}$/', $postcode);
    case 'NT':
      return preg_match('/^08\d{2}$/', $postcode);
    case 'WA':
      return preg_match('/^6\d{3}$/', $postcode);
    case 'SA':
      return preg_match('/^5\d{3}$/', $postcode);
    case 'TAS':
      return preg_match('/^7\d{3}$/', $postcode);
    case 'ACT':
      return preg_match('/^02\d{2}$/', $postcode);
    default:
      return false;
  }
}


// 1. Job Reference Number
$data['ref-number'] = sanitize_input($_POST['ref-number'] ?? '');
if ($data['ref-number'] == 'select') {
  $errors[] = "You must select a Job Reference Number.";
}

// 2. First Name
$data['first-name'] = sanitize_input($_POST['first-name'] ?? '');
if (empty($data['first-name'])) {
  $errors[] = "First Name is required.";
} elseif (!preg_match("/^[a-zA-Z]{1,20}$/", $data['first-name'])) {
  $errors[] = "First Name must be 1-20 alpha characters.";
}

// 3. Last Name
$data['last-name'] = sanitize_input($_POST['last-name'] ?? '');
if (empty($data['last-name'])) {
  $errors[] = "Last Name is required.";
} elseif (!preg_match("/^[a-zA-Z]{1,20}$/", $data['last-name'])) {
  $errors[] = "Last Name must be 1-20 alpha characters.";
}

// 4. Date of Birth
$data['date-of-birth'] = sanitize_input($_POST['date-of-birth'] ?? '');
if (empty($data['date-of-birth'])) {
  $errors[] = "Date of Birth is required.";
} else {
  $dob = new DateTime($data['date-of-birth']);
  $now = new DateTime();
  $age = $now->diff($dob)->y;
  if ($age < 15 || $age > 80) {
    $errors[] = "You must be between 15 and 80 years old to apply.";
  }
}

// 5. Gender
$data['gender'] = sanitize_input($_POST['gender'] ?? '');
if (empty($data['gender'])) {
  $errors[] = "Gender is required.";
}

// 6. Street Address
$data['address'] = sanitize_input($_POST['address'] ?? '');
if (empty($data['address'])) {
  $errors[] = "Street Address is required.";
} elseif (strlen($data['address']) > 40) {
  $errors[] = "Street Address must be max 40 characters.";
}

// 7. Suburb/Town
$data['suburb'] = sanitize_input($_POST['suburb'] ?? '');
if (empty($data['suburb'])) {
  $errors[] = "Suburb/Town is required.";
} elseif (strlen($data['suburb']) > 40) {
  $errors[] = "Suburb/Town must be max 40 characters.";
}

// 8. State
$data['state-selection'] = sanitize_input($_POST['state-selection'] ?? '');
if (empty($data['state-selection']) || $data['state-selection'] == 'state-selection') {
  $errors[] = "State is required.";
}

// 9. Postcode
$data['postcode'] = sanitize_input($_POST['postcode'] ?? '');
if (empty($data['postcode'])) {
  $errors[] = "Postcode is required.";
} elseif (!preg_match("/^[0-9]{4}$/", $data['postcode'])) {
  $errors[] = "Postcode must be exactly 4 digits.";
} elseif (!empty($data['state-selection']) && $data['state-selection'] != 'state-selection') {
  // Chỉ kiểm tra logic postcode nếu state đã hợp lệ
  if (!validate_postcode($data['state-selection'], $data['postcode'])) {
    $errors[] = "Postcode does not match the selected State.";
  }
}

// 10. Email
$data['email'] = sanitize_input($_POST['email'] ?? '');
if (empty($data['email'])) {
  $errors[] = "Email Address is required.";
} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
  $errors[] = "Email Address format is invalid.";
}

// 11. Phone Number
$data['phone-number'] = sanitize_input($_POST['phone-number'] ?? '');
if (empty($data['phone-number'])) {
  $errors[] = "Phone Number is required.";
} elseif (!preg_match("/^[\d\s]{8,12}$/", $data['phone-number'])) {
  $errors[] = "Phone Number must be 8 to 12 digits/spaces.";
}

// 12. Skills
$data['skills'] = $_POST['skills'] ?? [];
$data['other-skills'] = sanitize_input($_POST['other-skills'] ?? '');

if (empty($data['skills'])) {
  $errors[] = "You must select at least one skill other skills.";
}



// Nếu có lỗi, quay lại trang apply
if (!empty($errors)) {
  $_SESSION['errors'] = $errors;
  $_SESSION['old_data'] = $data; // Gửi lại dữ liệu cũ
  header("Location: apply.php");
  exit();
}

// === KHÔNG CÓ LỖI: TIẾN HÀNH LƯU VÀO CSDL ===

// Kết nối CSDL
$conn = @mysqli_connect($host, $user, $pwd, $db);

if (!$conn) {
  // Lỗi kết nối CSDL
  echo "<p>Database connection failure. Error: " . mysqli_connect_error() . "</p>";
  exit();
}

$sql_create_table = "CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    job_ref_num VARCHAR(10) NOT NULL,
    first_name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    street_address VARCHAR(40) NOT NULL,
    suburb VARCHAR(40) NOT NULL,
    state VARCHAR(5) NOT NULL,
    postcode VARCHAR(4) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(12) NOT NULL,
    skills_list TEXT,
    other_skills TEXT,
    status ENUM('New', 'Current', 'Final') DEFAULT 'New'
)";
$result_insertTable = mysqli_query($conn, $sql_create_table);

if (!$result_insertTable) {
  echo "<p>Error creating table: " . mysqli_error($conn) . "</p>";
  mysqli_close($conn);
  exit();
}

// Chuẩn bị dữ liệu để insert (chuyển mảng skills thành chuỗi)
$skills_string = implode(", ", $data['skills']);
$dob_sql_format = $data['date-of-birth'];

// Sử dụng Prepared Statements để chống SQL Injection
$sql_insert = "INSERT INTO eoi (job_ref_num, first_name, last_name, dob, gender, street_address, suburb, state, postcode, email, phone, skills_list, other_skills, status)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'New')";

$stmt = mysqli_prepare($conn, $sql_insert);

if ($stmt === false) {
  echo "<p>Error preparing statement: " . mysqli_error($conn) . "</p>";
  mysqli_close($conn);
  exit();
}

mysqli_stmt_bind_param(
  $stmt,
  "sssssssssssss",
  $data['ref-number'],
  $data['first-name'],
  $data['last-name'],
  $dob_sql_format,
  $data['gender'],
  $data['address'],
  $data['suburb'],
  $data['state-selection'],
  $data['postcode'],
  $data['email'],
  $data['phone-number'],
  $skills_string,
  $data['other-skills']
);

// Thực thi
if (mysqli_stmt_execute($stmt)) {
  // Thành công: Hiển thị trang xác nhận (Yêu cầu A4)
  $eoi_number = mysqli_insert_id($conn);

  // Đưa header và footer vào trang xác nhận
  $page_title = "Application Successful";
  include_once("header.inc");

  echo "<section class='back-G'>";
  echo "<div class='apply-box' style='text-align: center;'>";
  echo "<h1 class='h1' style='color: green;'>Thank You!</h1>";
  echo "<h2 class='h2'>Your application has been successfully submitted.</h2>";
  echo "<p style='font-size: 1.2em; margin-top: 20px;'>Your unique Expression of Interest (EOI) number is: <strong>$eoi_number</strong></p>";
  echo "<p>Please keep this number for your records.</p>";
  echo "<a href='index.php' style='display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: green; color: white; text-decoration: none; border-radius: 5px;'>Return Home</a>";
  echo "</div>";
  echo "</section>";

  include_once("footer.inc");

} else {
  // Lỗi khi insert
  echo "<p>Error: " . mysqli_error($conn) . "</p>";
}

// Đóng kết nối
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>