<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['faculty_email'])){
   header('location:login_form.php');
   exit();
}

// Get faculty information
$faculty_email = $_SESSION['faculty_email'];

// Get student count for faculty stats
$student_count_query = mysqli_query($conn, "SELECT * FROM user_form WHERE user_type = 'user'");
$student_count = mysqli_num_rows($student_count_query);

// Get total faculty count
$faculty_count_query = mysqli_query($conn, "SELECT * FROM faculty_table");
$faculty_count = mysqli_num_rows($faculty_count_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Faculty Dashboard - RBAC System</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard">
   <nav class="navbar">
      <div class="brand">
         <h2>Faculty Portal</h2>
      </div>
      <div class="user-info">
         <span>Welcome,</span>
         <span class="user-name"><?php echo $_SESSION['faculty_email']; ?></span>
         <a href="logout.php" class="logout-btn">Logout</a>
      </div>
   </nav>

   <div class="main-content">
      <!-- Welcome Card -->
      <div class="card">
         <h3>Welcome Faculty!</h3>
         <p>Hello <strong><?php echo $_SESSION['faculty_email']; ?></strong>, welcome to your faculty dashboard. Manage your courses, students, and academic activities from here.</p>
         <div style="margin-top: 20px;">
            <p style="margin: 10px 0; color: #4a5568;"><strong>Role:</strong> Faculty Member</p>
            <p style="margin: 10px 0; color: #4a5568;"><strong>Email:</strong> <?php echo $_SESSION['faculty_email']; ?></p>
            <p style="margin: 10px 0; color: #4a5568;"><strong>Status:</strong> <span style="color: #48bb78;">Active</span></p>
            <p style="margin: 10px 0; color: #4a5568;"><strong>Access Level:</strong> <span style="color: #667eea;">Faculty</span></p>
         </div>
      </div>

      <!-- Today's Overview -->
      <div class="card">
         <h3>Today's Overview</h3>
         <p>Quick overview of your academic activities and statistics</p>
         <div class="stats">
            <div class="stat-item">
               <div class="stat-number">8</div>
               <div class="stat-label">Classes Today</div>
            </div>
            <div class="stat-item">
               <div class="stat-number"><?php echo $student_count; ?></div>
               <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-item">
               <div class="stat-number">15</div>
               <div class="stat-label">Pending Reviews</div>
            </div>
         </div>
      </div>

      <!-- Course Management -->
      <div class="card">
         <h3>📖 Course Management</h3>
         <p>Manage your courses, curriculum, and academic content</p>
         <div style="background: rgba(102, 126, 234, 0.1); padding: 20px; border-radius: 10px; margin: 15px 0;">
            <h4 style="color: #4a5568; margin-bottom: 10px;">Active Courses</h4>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
               <span style="background: #667eea; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">Database Systems</span>
               <span style="background: #764ba2; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">Web Development</span>
               <span style="background: #48bb78; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">Data Structures</span>
               <span style="background: #ed8936; color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px;">Software Engineering</span>
            </div>
         </div>
         <div class="btn-group">
            <a href="#" class="btn">View All Courses</a>
            <a href="#" class="btn">Create New Course</a>
            <a href="#" class="btn secondary">Course Materials</a>
         </div>
      </div>

      <!-- Student Management -->
      <div class="card">
         <h3>👥 Student Management</h3>
         <p>View and manage student information, grades, and progress</p>
         <div style="margin: 20px 0;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
               <div style="background: rgba(72, 187, 120, 0.1); padding: 15px; border-radius: 10px; text-align: center;">
                  <div style="font-size: 24px; font-weight: bold; color: #48bb78;"><?php echo $student_count; ?></div>
                  <div style="font-size: 12px; color: #4a5568;">Enrolled Students</div>
               </div>
               <div style="background: rgba(237, 137, 54, 0.1); padding: 15px; border-radius: 10px; text-align: center;">
                  <div style="font-size: 24px; font-weight: bold; color: #ed8936;">23</div>
                  <div style="font-size: 12px; color: #4a5568;">Assignments Due</div>
               </div>
               <div style="background: rgba(102, 126, 234, 0.1); padding: 15px; border-radius: 10px; text-align: center;">
                  <div style="font-size: 24px; font-weight: bold; color: #667eea;">87%</div>
                  <div style="font-size: 12px; color: #4a5568;">Average Grade</div>
               </div>
            </div>
         </div>
         <div class="btn-group">
            <a href="#" class="btn">Student List</a>
            <a href="#" class="btn">Grade Book</a>
            <a href="#" class="btn secondary">Attendance</a>
         </div>
      </div>

      <!-- Quick Actions -->
      <div class="card">
         <h3>Quick Actions</h3>
         <p>Frequently used tools and shortcuts for daily tasks</p>
         <div class="btn-group">
            <a href="#" class="btn">Create Assignment</a>
            <a href="#" class="btn">Schedule Exam</a>
            <a href="#" class="btn secondary">Upload Materials</a>
            <a href="#" class="btn secondary">Send Announcement</a>
         </div>
      </div>

      <!-- Recent Activity -->
      <div class="card">
         <h3>📈 Recent Activity</h3>
         <p>Latest updates and activities from your courses</p>
         <div style="margin-top: 20px;">
            <div style="padding: 15px; background: rgba(102, 126, 234, 0.1); border-radius: 10px; margin: 10px 0; border-left: 4px solid #667eea;">
               <div style="display: flex; justify-content: between; align-items: center;">
                  <div>
                     <p style="margin: 0; color: #2d3748; font-weight: 600; font-size: 14px;">New Assignment Submission</p>
                     <p style="margin: 5px 0 0 0; color: #718096; font-size: 12px;">Database Design project submitted by 18 students</p>
                  </div>
                  <span style="color: #a0aec0; font-size: 11px;">2 hours ago</span>
               </div>
            </div>
            <div style="padding: 15px; background: rgba(72, 187, 120, 0.1); border-radius: 10px; margin: 10px 0; border-left: 4px solid #48bb78;">
               <div style="display: flex; justify-content: between; align-items: center;">
                  <div>
                     <p style="margin: 0; color: #2d3748; font-weight: 600; font-size: 14px;">Grades Published</p>
                     <p style="margin: 5px 0 0 0; color: #718096; font-size: 12px;">Mid-term examination results have been uploaded</p>
                  </div>
                  <span style="color: #a0aec0; font-size: 11px;">5 hours ago</span>
               </div>
            </div>
            <div style="padding: 15px; background: rgba(237, 137, 54, 0.1); border-radius: 10px; margin: 10px 0; border-left: 4px solid #ed8936;">
               <div style="display: flex; justify-content: between; align-items: center;">
                  <div>
                     <p style="margin: 0; color: #2d3748; font-weight: 600; font-size: 14px;">Meeting Reminder</p>
                     <p style="margin: 5px 0 0 0; color: #718096; font-size: 12px;">Faculty meeting scheduled for tomorrow at 10:00 AM</p>
                  </div>
                  <span style="color: #a0aec0; font-size: 11px;">1 day ago</span>
               </div>
            </div>
         </div>
      </div>

      <!-- Calendar & Schedule -->
      <div class="card">
         <h3>Today's Schedule</h3>
         <p>Your classes and meetings for today</p>
         <div style="margin-top: 20px;">
            <div style="padding: 12px; background: rgba(255, 255, 255, 0.5); border-radius: 8px; margin: 8px 0; display: flex; justify-content: space-between; align-items: center;">
               <div>
                  <p style="margin: 0; color: #2d3748; font-weight: 600; font-size: 14px;">Database Systems</p>
                  <p style="margin: 2px 0 0 0; color: #718096; font-size: 12px;">Room 101 • 45 students</p>
               </div>
               <span style="color: #667eea; font-weight: 600; font-size: 12px;">09:00 AM</span>
            </div>
            <div style="padding: 12px; background: rgba(255, 255, 255, 0.5); border-radius: 8px; margin: 8px 0; display: flex; justify-content: space-between; align-items: center;">
               <div>
                  <p style="margin: 0; color: #2d3748; font-weight: 600; font-size: 14px;">Web Development</p>
                  <p style="margin: 2px 0 0 0; color: #718096; font-size: 12px;">Lab 205 • 32 students</p>
               </div>
               <span style="color: #667eea; font-weight: 600; font-size: 12px;">11:30 AM</span>
            </div>
            <div style="padding: 12px; background: rgba(255, 255, 255, 0.5); border-radius: 8px; margin: 8px 0; display: flex; justify-content: space-between; align-items: center;">
               <div>
                  <p style="margin: 0; color: #2d3748; font-weight: 600; font-size: 14px;">Faculty Meeting</p>
                  <p style="margin: 2px 0 0 0; color: #718096; font-size: 12px;">Conference Room A</p>
               </div>
               <span style="color: #ed8936; font-weight: 600; font-size: 12px;">02:00 PM</span>
            </div>
         </div>
      </div>
   </div>
</div>

</body>
</html>
