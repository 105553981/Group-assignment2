<?php
include("header.inc");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enhancements</title>
  <link rel="stylesheet" href="styles/enhancement.css">
</head>

<body>
  <h1 class="main-title">Enhancements</h1>
  <div class="img">
    <img class="banner1" src="images/Banner1.png" alt="Hiring Banner">


  <div class="benefit-heading">
    <h2>
      This page documents the enhancements implemented in addition to the specified task requirements.<br />
      Each enhancement below includes an explanation of what was implemented and how it improves the website.
    </h2>
  </div>
      <img class="banner2" src="images/Banner2.png" alt="Hiring Banner">
  </div>

  <section class="card-container">
    <div class="card">
      <p><strong class="highlight">1. Sort EOI Records by Selected Field</strong></p>
      <div class="text-font-size">
        <p>
        I added a feature that allows the manager to choose which field to sort EOI records
        when viewing them in <code>manage.php</code>. A dropdown menu was added with options such as
        First Name, Last Name, Job Reference Number, and Date Applied.
      </p>
      <p>
        When the manager selects a field, the page reloads and the EOI records are sorted
        accordingly using an <code>ORDER BY</code> SQL query.
        This enhancement improves usability by allowing easier navigation of large EOI lists.
      </p>
      </div>
    </div>

    <div class="card">
      <p><strong class="highlight">2. Manager Registration Page with Server-Side Validation</strong></p>
      <div class="text-font-size">
      <p>I created a new manager registration page (<code>sign_up.php</code>) with full server-side validation.
        The system ensures:</p>
      <ul>
        <li><strong>Unique username: </strong>Checked using a SELECT query before inserting.</li>
        <li><strong>Password rule: </strong>Requires Maximum 20 characters.</li>
        <li><strong>Password hash: </strong>Password hashed more secure </li>
      </ul>
      <p>
        Valid information is stored securely in the <code>staff</code> table.
        Passwords are hashed using <code>password_hash()</code> for security.
        This enhancement provides safe and controlled account creation for managers.
      </p>
      </div>
    </div>

    <div class="card">
      <p><strong class="highlight">3. Access Control for manage.php</strong></p>
      <div class="text-font-size">
      <p>I implemented a login system (<code>sign_in.php</code>) that checks the manager's username and
        hashed password before granting access to <code>manage.php</code>.
      </p>
      <p>
        Only authenticated managers can view or manage EOI records.
        Sessions (<code>$_SESSION</code>) are used to maintain login state and prevent unauthorized access.
      </p>
      <p>This enhancement protects sensitive applicant data and meets industry security standards.</p>
      </div>
    </div>
  </section>

</body>

</html>

<?php
include_once("footer.inc");
?>