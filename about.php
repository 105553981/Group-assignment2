<?php
$page_title = "About Page";
include_once "header.inc"
  ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About</title>
  <link rel="stylesheet" href="styles/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="about">

  <section class="header-about">
    <div class="our-group">
      <h1>About Our Group</h1>
      <dl>
        <dt>
          <strong>Group Name:</strong>
        </dt>
        <dd>Danang_Group_2</dd>
        <dt>
          <strong>Group ID:</strong>
        </dt>
        <dd>2025-HX09-COS10026-Web Technology Project</dd>
        <dt>
          <strong>Tutor's Name:</strong>
        </dt>
        <dd>Mr. Hoang Nhu Vinh</dd>

        <dt>
          <strong>Members Contribution:</strong>
        </dt>
        <dd>
          <ul>
            <li>
              <strong>Nguyen Duc Phuc Thinh:</strong><br>
              "Index.php, About.php, CSS Designer, Sign_up.php, Process_eoi.php, Manage.php"
            <br>
              Student ID: 105553981
            </li>
            <ul>
              <li>
              <strong>Nguyen Tang Nhat Hung:</strong><br>
              "Apply.php and Jobs.php and its CSS, Sign_in.php, Process_eoi.php, Manage.php"
            <br>
              Student ID: 105707403
            </li>
          </ul>
        </dd>
      </dl>
    </div>
  </section>
  <div class="table-container">
    <div class="table">
      <h2>Class Time and Day</h2>
    </div>
    <table>
      <thead class="table-heading1">
        <tr>
          <th>Day</th>
          <th>Time</th>
          <th>Activity</th>
        </tr>
      </thead>
      <tbody class="table-body1">
        <tr>
          <td>Monday</td>
          <td>8:00 AM - 12:00 PM</td>
          <td>Project Meeting</td>
        </tr>
        <tr>
          <td>Wednesday</td>
          <td>13:00 PM - 17:00 PM</td>
          <td>Development Project</td>
        </tr>
        <tr>
          <td>Friday</td>
          <td>10:00 AM - 15:00 PM</td>
          <td>Testing, Fix Bug & Review</td>
        </tr>
      </tbody>
    </table>
    <div class="table">
      <h2>Group DemoGraphics</h2>
    </div>
    <table>
      <tbody class="table-body2-3-4-5">
        <tr>
          <th>Age Range</th>
          <td>20-30 Years Old</td>
        </tr>
        <tr>
          <th>Gender</th>
          <td>4 Female, 2 Male</td>
        </tr>
        <tr>
          <th>Education Level</th>
          <td>Master's degree of computer in Swinburne University</td>
        </tr>
      </tbody>
    </table>
    <div class="table">
      <h2>HomeTown Descriptions</h2>
    </div>
    <table>
      <tbody class="table-body2-3-4-5">
        <tr>
          <th>City</th>
          <td>Da Nang, Viet Nam</td>
        </tr>
        <tr>
          <th>Population</th>
          <td>Approximately 1.2 million people</td>
        </tr>
        <tr>
          <th>Notable Feature</th>
          <td>
            Beautiful My Khe beaches, the Dragon Bridge, Marble Mountains, and
            the Bustling Han Market.
          </td>
        </tr>
        <tr>
          <th>Climate</th>
          <td>Distinct wet and Dry seasons.</td>
        </tr>
      </tbody>
    </table>
    <div class="table">
      <h2>Progamming Skills</h2>
    </div>
    <table>
      <tbody class="table-body2-3-4-5">
        <tr>
          <th>Languages</th>
          <td>Python, Java, C++, JavaScript, PHP, HTML/CSS</td>
        </tr>
        <tr>
          <th>Frameworks</th>
          <td>React, Node.js, Django</td>
        </tr>
        <tr>
          <th>Tools</th>
          <td>Git, Docker, Jenkins</td>
        </tr>
        <tr>
          <th>Experience</th>
          <td>At least 2 years of experience in software development</td>
        </tr>
      </tbody>
    </table>
    <div class="table">
      <h2>Working-Places</h2>
    </div>
    <table>
      <tbody class="table-body2-3-4-5">
        <tr>
          <th>Companies</th>
          <td>Webtech, XYZ Solutions, Creative Code Co</td>
        </tr>
        <tr>
          <th>Roles</th>
          <td>
            Software Developer, Frontend Engineer, DevOps Specialist, Project
            Manager, Data Analyst
          </td>
        </tr>
        <tr>
          <th>Projects</th>
          <td>
            Websites, mobile apps, data analysis tools, and cloud-based
            solutions, Cybersecurity.
          </td>
        </tr>
      </tbody>
    </table>
    <div class="contact">
      <h2>Contact with us at:</h2>
      <p>
        <a href="mailto:105707403@student.swin.edu.au">105707403@student.swin.edu.au</a>
      </p>
    </div>
  </div>

</html>
<?php
include_once("footer.inc");
?>