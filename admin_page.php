<?php
@include 'config.php';

session_start();

if(!isset($_SESSION['admin_name'])){
   header('location:login_form.php');
}

// Get statistics
$user_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_form WHERE user_type = 'user' AND status = 'approved'"));
$admin_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_form WHERE user_type = 'admin'"));
$faculty_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM faculty_table"));
$pending_count = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_form WHERE status = 'pending'"));

// Handle user approval/rejection
if(isset($_POST['approve_user'])){
   $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
   $update_query = "UPDATE user_form SET status = 'approved' WHERE id = '$user_id'";
   if(mysqli_query($conn, $update_query)){
      $success[] = 'User approved successfully!';
   }else{
      $error[] = 'Failed to approve user!';
   }
}

if(isset($_POST['reject_user'])){
   $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
   $update_query = "UPDATE user_form SET status = 'rejected' WHERE id = '$user_id'";
   if(mysqli_query($conn, $update_query)){
      $success[] = 'User rejected successfully!';
   }else{
      $error[] = 'Failed to reject user!';
   }
}

// Handle faculty addition
if(isset($_POST['add_faculty'])){
   $faculty_email = mysqli_real_escape_string($conn, $_POST['faculty_email']);
   $faculty_password = md5($_POST['faculty_password']);

   // Check if faculty already exists
   $check_faculty = "SELECT * FROM faculty_table WHERE email = '$faculty_email'";
   $check_result = mysqli_query($conn, $check_faculty);
   
   if(mysqli_num_rows($check_result) > 0){
      $error[] = 'Faculty member already exists!';
   }else{
      $insert_query = "INSERT INTO faculty_table (email, password) VALUES ('$faculty_email', '$faculty_password')";
      if(mysqli_query($conn, $insert_query)){
         $success[] = 'Faculty member added successfully!';
      }else{
         $error[] = 'Failed to add faculty member!';
      }
   }
}

// Handle admin code generation
if(isset($_POST['generate_admin_code'])){
   $new_code = 'ADMIN_' . strtoupper(substr(md5(time()), 0, 8));
   $insert_code = "INSERT INTO admin_codes (code) VALUES ('$new_code')";
   if(mysqli_query($conn, $insert_code)){
      $success[] = 'New admin code generated: ' . $new_code;
   }else{
      $error[] = 'Failed to generate admin code!';
   }
}

// Get pending users
$pending_users_query = "SELECT * FROM user_form WHERE status = 'pending' ORDER BY id DESC";
$pending_users_result = mysqli_query($conn, $pending_users_query);

// Get admin codes
$admin_codes_query = "SELECT * FROM admin_codes ORDER BY created_at DESC LIMIT 10";
$admin_codes_result = mysqli_query($conn, $admin_codes_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Dashboard - RBAC System</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard">
   <nav class="navbar">
      <div class="brand">
         <h2>🔐 Admin Dashboard</h2>
      </div>
      <div class="user-info">
         <span>Welcome back,</span>
         <span class="user-name"><?php echo $_SESSION['admin_name']; ?></span>
         <a href="logout.php" class="logout-btn">Logout</a>
      </div>
   </nav>

   <div class="main-content">
      <!-- System Statistics -->
      <div class="card">
         <h3>📊 System Statistics</h3>
         <p>Overview of users and roles in the system</p>
         <div class="stats">
            <div class="stat-item">
               <div class="stat-number"><?php echo $user_count; ?></div>
               <div class="stat-label">Approved Students</div>
            </div>
            <div class="stat-item">
               <div class="stat-number"><?php echo $pending_count; ?></div>
               <div class="stat-label">Pending Approvals</div>
            </div>
            <div class="stat-item">
               <div class="stat-number"><?php echo $faculty_count; ?></div>
               <div class="stat-label">Faculty</div>
            </div>
            <div class="stat-item">
               <div class="stat-number"><?php echo $admin_count; ?></div>
               <div class="stat-label">Admins</div>
            </div>
         </div>
      </div>

      <!-- Pending User Approvals -->
      <div class="card">
         <h3>👥 Pending User Approvals</h3>
         <p>Review and approve new user registrations</p>
         
         <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<div class="error-msg">'.$error.'</div>';
            };
         };
         if(isset($success)){
            foreach($success as $success){
               echo '<div style="margin:15px 0; padding:12px 16px; background:linear-gradient(135deg, #48bb78 0%, #38a169 100%); color:white; border-radius:10px; font-size:14px;">'.$success.'</div>';
            };
         };
         ?>
         
         <div style="margin-top: 20px;">
            <?php if(mysqli_num_rows($pending_users_result) > 0): ?>
               <?php while($pending_user = mysqli_fetch_array($pending_users_result)): ?>
                  <div style="background: rgba(30, 41, 59, 0.5); border-radius: 12px; padding: 20px; margin: 15px 0; border: 1px solid rgba(59, 130, 246, 0.2);">
                     <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <div>
                           <h4 style="color: #f8fafc; margin: 0; font-size: 16px;"><?php echo $pending_user['name']; ?></h4>
                           <p style="color: #94a3b8; margin: 5px 0; font-size: 14px;"><?php echo $pending_user['email']; ?></p>
                           <span style="background: #667eea; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; text-transform: uppercase;">
                              <?php echo $pending_user['user_type']; ?>
                           </span>
                        </div>
                        <div style="display: flex; gap: 10px;">
                           <form method="post" style="display: inline;">
                              <input type="hidden" name="user_id" value="<?php echo $pending_user['id']; ?>">
                              <button type="submit" name="approve_user" class="btn" style="padding: 8px 16px; font-size: 12px; min-width: auto;">
                                 ✓ Approve
                              </button>
                           </form>
                           <form method="post" style="display: inline;">
                              <input type="hidden" name="user_id" value="<?php echo $pending_user['id']; ?>">
                              <button type="submit" name="reject_user" class="btn" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); padding: 8px 16px; font-size: 12px; min-width: auto;">
                                 ✗ Reject
                              </button>
                           </form>
                        </div>
                     </div>
                  </div>
               <?php endwhile; ?>
            <?php else: ?>
               <div style="text-align: center; padding: 40px; color: #94a3b8;">
                  <p>No pending approvals at this time.</p>
               </div>
            <?php endif; ?>
         </div>
      </div>

      <!-- Admin Code Management -->
      <div class="card">
         <h3>🔑 Admin Code Management</h3>
         <p>Generate and manage admin authorization codes</p>
         
         <form method="post" style="margin: 20px 0;">
            <button type="submit" name="generate_admin_code" class="btn">Generate New Admin Code</button>
         </form>
         
         <div style="background: rgba(30, 41, 59, 0.5); border-radius: 12px; padding: 20px; margin: 15px 0;">
            <h4 style="color: #f8fafc; margin-bottom: 15px;">Recent Admin Codes</h4>
            <?php if(mysqli_num_rows($admin_codes_result) > 0): ?>
               <div style="max-height: 200px; overflow-y: auto;">
                  <?php while($code = mysqli_fetch_array($admin_codes_result)): ?>
                     <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid rgba(59, 130, 246, 0.1);">
                        <div>
                           <code style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; padding: 4px 8px; border-radius: 4px; font-family: monospace;">
                              <?php echo $code['code']; ?>
                           </code>
                        </div>
                        <div style="font-size: 12px; color: #94a3b8;">
                           <?php if($code['is_used']): ?>
                              <span style="color: #ef4444;">Used</span>
                           <?php else: ?>
                              <span style="color: #10b981;">Available</span>
                           <?php endif; ?>
                        </div>
                     </div>
                  <?php endwhile; ?>
               </div>
            <?php else: ?>
               <p style="color: #94a3b8; text-align: center;">No admin codes generated yet.</p>
            <?php endif; ?>
         </div>
      </div>

      <!-- Quick Actions -->
      <div class="card">
         <h3>⚡ Quick Actions</h3>
         <p>Manage system users and access controls</p>
         <div class="btn-group">
            <a href="register_form.php" class="btn">Add User</a>
            <a href="login_form.php" class="btn secondary">Login Portal</a>
         </div>
      </div>

      <!-- Add Faculty Member -->
      <div class="card">
         <h3>👨‍🏫 Faculty Management</h3>
         <p>Add and manage faculty members</p>
         
         <div class="add-faculty-form">
            <form action="" method="post">
               <h4>Add New Faculty Member</h4>
               <input type="email" name="faculty_email" required placeholder="Faculty email address">
               <input type="password" name="faculty_password" required placeholder="Temporary password">
               <input type="submit" name="add_faculty" value="Add Faculty" class="form-btn">
            </form>
         </div>
      </div>

      <!-- System Information -->
      <div class="card">
         <h3>ℹ️ System Information</h3>
         <p>Current system status and information</p>
         <div style="margin-top: 20px;">
            <p style="margin: 10px 0; color: #4a5568;"><strong>System Status:</strong> <span style="color: #48bb78;">Active</span></p>
            <p style="margin: 10px 0; color: #4a5568;"><strong>Database:</strong> Connected</p>
            <p style="margin: 10px 0; color: #4a5568;"><strong>Access Level:</strong> Administrator</p>
            <p style="margin: 10px 0; color: #4a5568;"><strong>Security:</strong> <span style="color: #10b981;">Enhanced with Approval System</span></p>
         </div>
      </div>
   </div>
</div>

</body>
</html>