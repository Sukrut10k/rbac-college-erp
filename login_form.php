<?php
@include 'config.php';

session_start();

if(isset($_POST['submit'])){
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);

   $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_array($result);

      // Check if user is approved
      if($row['status'] != 'approved'){
         if($row['status'] == 'pending'){
            $error[] = 'Your account is pending approval. Please wait for admin approval.';
         }elseif($row['status'] == 'rejected'){
            $error[] = 'Your account has been rejected. Please contact administrator.';
         }
      }else{
         // User is approved, proceed with login
         if($row['user_type'] == 'admin'){
            $_SESSION['admin_name'] = $row['name'];
            header('location:admin_page.php');
         }elseif($row['user_type'] == 'user'){
            $_SESSION['user_name'] = $row['name'];
            header('location:user_page.php');
         }
      }
   }else{
      // Check faculty table
      $faculty_select = "SELECT * FROM faculty_table WHERE email = '$email' && password = '$pass'";
      $faculty_result = mysqli_query($conn, $faculty_select);
      
      if(mysqli_num_rows($faculty_result) > 0){
         $_SESSION['faculty_email'] = $email;
         header('location:faculty_member_page.php');
      }else{
         $error[] = 'Incorrect email or password!';
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
   <title>Login - RBAC System</title>
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
         <h3>Welcome Back</h3>
         
         <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            };
         };
         ?>
         
         <div class="form-group">
            <input type="email" name="email" required placeholder="Enter your email address">
         </div>
         
         <div class="form-group">
            <input type="password" name="password" required placeholder="Enter your password">
         </div>
         
         <input type="submit" name="submit" value="Sign In" class="form-btn">
         
         <p>Don't have an account? <a href="register_form.php">Create Account</a></p>
      </form>
   </div>
</div>

</body>
</html>
