<?php
session_start();
$page_title = "Apply";
include_once("header.inc");


$errors = $_SESSION['errors'] ?? [];
$old_data = $_SESSION['old_data'] ?? [];


unset($_SESSION['errors']);
unset($_SESSION['old_data']);


function get_old($field)
{
  global $old_data;
  return $old_data[$field] ?? '';
}

function is_checked($field, $value)
{
  global $old_data;
  if (isset($old_data[$field])) {

    if (is_array($old_data[$field])) {
      return in_array($value, $old_data[$field]) ? 'checked' : '';
    }
    return ($old_data[$field] == $value) ? 'checked' : '';
  }
  return '';
}

// Hàm trợ giúp để chọn select cũ
function is_selected($field, $value)
{
  global $old_data;
  return (isset($old_data[$field]) && $old_data[$field] == $value) ? 'selected' : '';
}
?>

<head>
  <title><?php echo $page_title; ?></title>
</head>

<form method="post" action="process_eoi.php" novalidate="novalidate">
  <section class="back-G">
    <h1 class="h1">Getting jobs at <span class="highlight">Webtech?</span></h1>
    <h2 class="h2">Just a few seconds for filling this Form</h2>

    <?php if (!empty($errors)): ?>
      <div class="apply-box" style="background-color: #ffcccc; border: 2px solid red;">
        <h4 class="form-heading" style="color: red;">Please correct the following errors:</h4>
        <ul style="margin-left: 20px;">
          <?php foreach ($errors as $error): ?>
            <li style="color: red;"><?php echo $error; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <section class="apply-box">
      <div class="form-header">
        <img class="form-logo" src="images/logo.png" alt="Webtech Logo">
        <hr>
        <h3 id="header-text">Job Application</h3>
      </div>

      <h4 class="form-heading">Position</h4>
      <hr class="end-line-heading">
      <label for="ref-number" class="highlight"><strong>Position you are applying for</strong></label>
      <select class="ref-number" name="ref-number" id="ref-number">
        <option value="select" <?php echo is_selected('ref-number', value: 'select'); ?>>Job Reference Number</option>
        <option value="ML183" <?php echo is_selected('ref-number', 'ML183'); ?>>ML183 - Senior Machine Learning Engineer
        </option>
        <option value="SE358" <?php echo is_selected('ref-number', 'SE358'); ?>>SE358 - Full-Stack Software Engineer
        </option>
        <option value="SE490" <?php echo is_selected('ref-number', 'SE490'); ?>>SE490 - Software Engineer - SoC Power
          Management</option>
        <option value="IS511" <?php echo is_selected('ref-number', 'IS511'); ?>>IS511 - Systems Software Engineer,
          Information Security</option>
        <option value="AI582" <?php echo is_selected('ref-number', 'AI582'); ?>>AI582 - AI Product Manager</option>
        <option value="HI689" <?php echo is_selected('ref-number', 'HI689'); ?>>HI689 - Hardware Technology Internships
        </option>
      </select>

      <h4 class="form-heading">Personal Information</h4>
      <hr class="end-line-heading">
      <div class="name">
        <p class="fill-info-container">
          <label for="first-name" class="highlight"><strong>First Name</strong></label>
          <input type="text" pattern="[a-zA-Z]+" name="first-name" id="first-name" maxlength="20" size="20" required
            title="Max 20 alpha characters" value="<?php echo get_old('first-name'); ?>">
        </p>
        <p class="fill-info-container">
          <label for="last-name" class="highlight"><strong>Last Name</strong></label>
          <input type="text" pattern="[a-zA-Z]+" name="last-name" id="last-name" maxlength="20" size="20" required
            title="Max 20 alpha characters" value="<?php echo get_old('last-name'); ?>">
        </p>
        <p class="fill-info-container">
          <label for="date-of-birth" class="highlight"><strong>Date of Birth</strong></label>
          <input type="date" name="date-of-birth" id="date-of-birth" size="10"
            value="<?php echo get_old('date-of-birth'); ?>">
        </p>
      </div>
      <div class="address">
        <p class="fill-info-container">
          <label for="address" class="highlight"><strong>Street Address</strong></label>
          <input type="text" name="address" id="address" maxlength="40" size="30" required title="Max 40 characters"
            value="<?php echo get_old('address'); ?>">
        </p>
        <p class="fill-info-container">
          <label for="suburb/town" class="highlight"><strong>Suburb/Town</strong></label>
          <input type="text" name="suburb" id="suburb/town" maxlength="40" size="30" required title="Max 40 characters"
            value="<?php echo get_old('suburb'); ?>">
        </p>
        <p class="fill-info-container">
          <label for="state-selection" class="highlight"><strong>State</strong></label>
          <select name="state-selection" id="state-selection">
            <option value="state-selection" <?php echo is_selected('state-selection', 'state-selection'); ?>>Select
              State</option>
            <option value="VIC" <?php echo is_selected('state-selection', 'VIC'); ?>>VIC</option>
            <option value="NSW" <?php echo is_selected('state-selection', 'NSW'); ?>>NSW</option>
            <option value="QLD" <?php echo is_selected('state-selection', 'QLD'); ?>>QLD</option>
            <option value="NT" <?php echo is_selected('state-selection', 'NT'); ?>>NT</option>
            <option value="WA" <?php echo is_selected('state-selection', 'WA'); ?>>WA</option>
            <option value="SA" <?php echo is_selected('state-selection', 'SA'); ?>>SA</option>
            <option value="TAS" <?php echo is_selected('state-selection', 'TAS'); ?>>TAS</option>
            <option value="ACT" <?php echo is_selected('state-selection', 'ACT'); ?>>ACT</option>
          </select>
        </p>
        <p class="fill-info-container">
          <label for="postcode" class="highlight"><strong>Postcode</strong></label>
          <input type="text" pattern="[0-9]{4}" name="postcode" id="postcode" maxlength="4" size="11" required
            title="Exactly 4 digits" value="<?php echo get_old('postcode'); ?>">
        </p>
      </div>
      <div class="gender">
        <fieldset>
          <legend class="highlight"><strong>Your Gender</strong></legend>
          <input type="radio" id="male" name="gender" value="male" <?php echo is_checked('gender', 'male'); ?>>
          <label for="male">Male</label>
          <input type="radio" id="women" name="gender" value="women" <?php echo is_checked('gender', 'women'); ?>>
          <label for="women">Women</label>
          <input type="radio" id="other" name="gender" value="other" <?php echo is_checked('gender', 'other'); ?>>
          <label for="other">Other</label>
        </fieldset>
      </div>
      <div class="contact-information">
        <p class="fill-info-container">
          <label for="email" class="highlight"><strong>Email Address</strong></label>
          <input type="text" class="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" name="email" id="email"
            size="30" value="<?php echo get_old('email'); ?>">
        </p>
        <p class="fill-info-container">
          <label for="phone-number" class="highlight"><strong>Phone Number</strong></label>
          <input type="tel" class="phone" pattern="[0-9]{8,12}" name="phone-number" id="phone-number" size="30" required
            title="8 to 12 digits, or spaces" value="<?php echo get_old('phone-number'); ?>">
        </p>
      </div>

      <div class="skills">
        <h4 class="form-heading"><strong>Skills</strong></h4>
        <hr class="end-line-heading">
        <fieldset>
          <legend class="highlight"><strong>Selecting skills that you have:</strong></legend>
          <input type="checkbox" id="python" name="skills[]" value="python" <?php echo is_checked('skills', 'python'); ?>>
          <label for="python">Python</label>
          <input type="checkbox" id="java" name="skills[]" value="java" <?php echo is_checked('skills', 'java'); ?>>
          <label for="java">Java</label>
          <input type="checkbox" id="c#" name="skills[]" value="c#" <?php echo is_checked('skills', 'c#'); ?>>
          <label for="c#">C#</label>
          <input type="checkbox" id="javascript" name="skills[]" value="javascript" <?php echo is_checked('skills', 'javascript'); ?>>
          <label for="javascript">JavaScript</label>
        </fieldset>
        <div class="other-skills">
          <div class="fill-info-container">
            <label for="other-skills" class="highlight"><strong>Other Skills</strong></label>
            <textarea name="other-skills" id="other-skills" rows="6"
              placeholder="Typing your other skills here..."><?php echo get_old('other-skills'); ?></textarea>
          </div>
        </div>
      </div>

      <div class="button_container">
        <input type="submit" id="submit-button" value="Apply">
        <input type="reset" id="reset-button" value="Reset">
      </div>
    </section>
  </section>

  <div class="search-wrap">
  </div>
  <div class="job-section">
  </div>
</form>

<?php
include_once("footer.inc"); // Thêm footer
?>