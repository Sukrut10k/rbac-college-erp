<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}

// Get student information
$student_name = $_SESSION['user_name'];
$student_query = "SELECT * FROM user_form WHERE name = '$student_name'";
$student_result = mysqli_query($conn, $student_query);
$student_data = mysqli_fetch_array($student_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Student Dashboard - RBAC System</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard">
   <nav class="navbar">
      <div class="brand">
         <h2>🎓 Student Portal</h2>
      </div>
      <div class="user-info">
         <span>Welcome,</span>
         <span class="user-name"><?php echo $_SESSION['user_name']; ?></span>
         <a href="logout.php" class="logout-btn">Logout</a>
      </div>
   </nav>

   <div class="main-content">
      <!-- Welcome Card -->
      <div class="card">
         <h3>👋 Welcome Back!</h3>
         <p>Hello <strong><?php echo $_SESSION['user_name']; ?></strong>, welcome to your student dashboard. Here you can access all your academic resources and information.</p>
         <div style="margin-top: 20px;">
            <p style="margin: 10px 0; color: #4a5568;"><strong>Role:</strong> Student</p>
            <p style="margin: 10px 0; color: #4a5568;"><strong>Email:</strong> <?php echo $student_data['email']; ?></p>
            <p style="margin: 10px 0; color: #4a5568;"><strong>Status:</strong> <span style="color: #48bb78;">Active</span></p>
         </div>
      </div>

      <!-- Academic Resources -->
      <div class="card">
         <h3>📚 Academic Resources</h3>
         <p>Access your courses, assignments, and academic materials</p>
         <div class="btn-group">
            <a href="#" class="btn">My Courses</a>
            <a href="#" class="btn">Assignments</a>
            <a href="#" class="btn">Grades</a>
         </div>
      </div>

      <!-- Quick Links -->
      <div class="card">
         <h3>🔗 Quick Links</h3>
         <p>Frequently used links and resources</p>
         <div class="btn-group">
            <a href="#" class="btn secondary">Library</a>
            <a href="#" class="btn secondary">Schedule</a>
            <a href="#" class="btn secondary">Profile</a>
         </div>
      </div>

      <!-- Announcements -->
      <div class="card">
         <h3>📢 Announcements</h3>
         <p>Latest updates and announcements</p>
         <div style="margin-top: 20px;">
            <div style="padding: 15px; background: rgba(102, 126, 234, 0.1); border-radius: 10px; margin: 10px 0;">
               <p style="margin: 0; color: #4a5568; font-size: 14px;"><strong>System Update:</strong> New features have been added to the student portal.</p>
            </div>
            <div style="padding: 15px; background: rgba(72, 187, 120, 0.1); border-radius: 10px; margin: 10px 0;">
               <p style="margin: 0; color: #4a5568; font-size: 14px;"><strong>Academic Calendar:</strong> Mid-term examinations start next week.</p>
            </div>
         </div>
      </div>

      <!-- Help & Support -->
      <div class="card">
         <h3>❓ Help & Support</h3>
         <p>Get help and contact support when needed</p>
         <div class="btn-group">
            <a href="#" class="btn">Contact Support</a>
            <a href="#" class="btn secondary">Help Center</a>
         </div>
      </div>

      <!-- Account Management -->
      <div class="card">
         <h3>⚙️ Account Settings</h3>
         <p>Manage your account and preferences</p>
         <div class="btn-group">
            <a href="login_form.php" class="btn secondary">Login Portal</a>
            <a href="register_form.php" class="btn secondary">Registration</a>
         </div>
      </div>
   </div>
</div>

</body>
</html>