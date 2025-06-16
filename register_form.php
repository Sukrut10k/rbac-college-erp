<?php
@include 'config.php';

if(isset($_POST['submit'])){
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = "SELECT * FROM user_form WHERE email = '$email'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'User already exists!';
   }else{
      if($pass != $cpass){
         $error[] = 'Passwords do not match!';
      }else{
         // Check if user is trying to register as admin
         if($user_type == 'admin'){
            $admin_code = mysqli_real_escape_string($conn, $_POST['admin_code']);
            
            // Verify admin code
            $code_check = "SELECT * FROM admin_codes WHERE code = '$admin_code' AND is_used = FALSE";
            $code_result = mysqli_query($conn, $code_check);
            
            if(mysqli_num_rows($code_result) == 0){
               $error[] = 'Invalid or already used admin code!';
            }else{
               // Mark admin code as used and insert admin user
               $update_code = "UPDATE admin_codes SET is_used = TRUE, used_at = NOW(), used_by = '$email' WHERE code = '$admin_code'";
               mysqli_query($conn, $update_code);
               
               $insert = "INSERT INTO user_form(name, email, password, user_type, status) VALUES('$name','$email','$pass','$user_type','approved')";
               mysqli_query($conn, $insert);
               $success[] = 'Admin registration successful! You can now login.';
            }
         }else{
            // Regular user registration - requires approval
            $insert = "INSERT INTO user_form(name, email, password, user_type, status) VALUES('$name','$email','$pass','$user_type','pending')";
            mysqli_query($conn, $insert);
            $success[] = 'Registration successful! Please wait for admin approval before logging in.';
         }
      }
   }
};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register - RBAC System</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<div class="form-container">
   <div class="form-wrapper">
      <div class="logo">
         <h2>RBAC System</h2>
         <p>Role-Based Access Control</p>
      </div>
      
      <form action="" method="post">
         <h3>Create Account</h3>
         
         <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            };
         };
         if(isset($success)){
            foreach($success as $success){
               echo '<div style="margin:15px 0; padding:12px 16px; background:linear-gradient(135deg, #48bb78 0%, #38a169 100%); color:white; border-radius:10px; font-size:14px;">'.$success.'</div>';
            };
         };
         ?>
         
         <div class="form-group">
            <input type="text" name="name" required placeholder="Enter your full name">
         </div>
         
         <div class="form-group">
            <input type="email" name="email" required placeholder="Enter your email address">
         </div>
         
         <div class="form-group">
            <input type="password" name="password" required placeholder="Create a password">
         </div>
         
         <div class="form-group">
            <input type="password" name="cpassword" required placeholder="Confirm your password">
         </div>
         
         <div class="form-group">
            <select name="user_type" id="user_type" required onchange="toggleAdminCode()">
               <option value="">Select Role</option>
               <option value="user">Student</option>
               <option value="admin">Administrator</option>
            </select>
         </div>
         
         <div class="form-group" id="admin_code_field" style="display: none;">
            <input type="text" name="admin_code" placeholder="Enter admin authorization code">
            <small style="color: #94a3b8; font-size: 12px; display: block; margin-top: 5px;">
               Admin code is required to register as administrator
            </small>
         </div>
         
         <input type="submit" name="submit" value="Create Account" class="form-btn">
         
         <p>Already have an account? <a href="login_form.php">Sign In</a></p>
      </form>
   </div>
</div>

<script>
function toggleAdminCode() {
    const userType = document.getElementById('user_type').value;
    const adminCodeField = document.getElementById('admin_code_field');
    
    if (userType === 'admin') {
        adminCodeField.style.display = 'block';
        document.querySelector('input[name="admin_code"]').required = true;
    } else {
        adminCodeField.style.display = 'none';
        document.querySelector('input[name="admin_code"]').required = false;
    }
}
</script>

</body>
</html>
