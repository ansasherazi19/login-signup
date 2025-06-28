<?php 
include ("include/header.php");
require("include/connection.php");

if(isset($_POST['signup'])){
   $username = mysqli_real_escape_string($connection, $_POST['username']);
   $email = mysqli_real_escape_string($connection, $_POST['email']);
   $password = mysqli_real_escape_string($connection, $_POST['password']);
   $confirm_password = mysqli_real_escape_string($connection, $_POST['confirmPassword']);
   $first_name = mysqli_real_escape_string($connection, $_POST['firstName']);
   $last_name = mysqli_real_escape_string($connection, $_POST['lastName']);

   if ($password !== $confirm_password) {
       echo "<script>alert('Passwords do not match');</script>";
       exit;
   }

   $profile_picture = NULL;
   if(isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0){
       $target_dir = "uploads/";
       if(!is_dir($target_dir)) {
           mkdir($target_dir, 0777, true);
       }
       $profile_picture = $target_dir . basename($_FILES["profileImage"]["name"]);
       move_uploaded_file($_FILES["profileImage"]["tmp_name"], $profile_picture);
   }

   $encryptedPassword = password_hash($password, PASSWORD_BCRYPT);

   $check = "SELECT * FROM users WHERE email='$email';";
   $res = mysqli_query($connection, $check) or die("Query Failed: " . mysqli_error($connection));

   if(mysqli_num_rows($res) > 0){
       echo "<script>
       alert('Already registered. Please Login Now..!');
       window.location.href='signin.php';
       </script>";
   }
   else{
       $insert = "INSERT INTO `users` (`username`, `email`, `password_hash`, `first_name`, `last_name`, `profile_picture`, `created_at`) 
                  VALUES ('$username', '$email', '$encryptedPassword', '$first_name', '$last_name', '$profile_picture', NOW());";
       $result = mysqli_query($connection, $insert) or die("Insert Query Failed: " . mysqli_error($connection));

       if($result){
           echo "<script>
           alert('Account Successfully Created.');
           window.location.href='signin.php';
           </script>";
       }
       else{
           echo "<script>alert('Failed to Create your account.')</script>";
       }
   }
}

?> 










<body>
  <div class="form-container sign-up-container">
    <form action="signup.php"  method="POST" enctype="multipart/form-data" id="signupForm">
      <h1>Create Account</h1>

      <div class="social-container">
        <a href="#" class="social">
          <svg width="26" height="26" viewBox="0 0 320 512" fill="#3b5998">
            <path d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0C141.09 0 89.09 54.42 89.09 153.12v68.22H0v92.66h89.09V512h107.77V288z"/>
          </svg>
        </a>

        <a href="#" class="social">
          <svg width="20" height="20" viewBox="0 0 533.5 544.3">
            <path fill="#4285f4" d="M533.5 278.4c0-17.4-1.5-34.1-4.3-50.3H272v95.3h146.9c-6.3 34.1-25.1 63-53.6 82.4v68.2h86.6c50.7-46.7 81.6-115.5 81.6-195.6z"/>
            <path fill="#34a853" d="M272 544.3c72.9 0 134.1-24.2 178.8-65.8l-86.6-68.2c-24.1 16.1-55 25.6-92.2 25.6-70.9 0-131-47.9-152.4-112.1H32.1v70.9C76.7 483.2 168.2 544.3 272 544.3z"/>
            <path fill="#fbbc04" d="M119.6 323.7c-10.8-32.3-10.8-66.6 0-98.9V153.9H32.1c-37.4 74.8-37.4 162.6 0 237.4l87.5-67.6z"/>
            <path fill="#ea4335" d="M272 107.3c39.6-.6 77.9 14 106.7 40.3l79.6-79.6C414.2 24.7 345.5-1 272 0 168.2 0 76.7 61.1 32.1 153.9l87.5 70.9C141 155.1 201.1 107.3 272 107.3z"/>
          </svg>
        </a>

        <a href="#" class="social">
          <svg width="20" height="20" viewBox="0 0 34 34" fill="#0077B5">
            <path d="M34,20.2v11.6h-6.8v-10c0-2.5-0.9-4.3-3.2-4.3c-1.7,0-2.7,1.2-3.1,2.3c-0.2,0.5-0.2,1.2-0.2,1.8v10.2h-6.8c0,0,0.1-16.5,0-18.2h6.8v2.6c0.9-1.4,2.5-3.4,6.1-3.4C31.1,12.9,34,15.5,34,20.2z M4,0.5C1.8,0.5,0,2.3,0,4.5S1.8,8.5,4,8.5s4-1.8,4-4S6.2,0.5,4,0.5z M0.6,31.8H7.4V13.6H0.6V31.8z"/>
          </svg>
        </a>
      </div>

      <span>or use your email for registration</span>

      <!-- Inline name inputs -->
      <div class="inline-name">
        <div class="input-box">
          <input type="text" class="first" id="firstName" name="firstName" placeholder="First Name"/>
          <p class="error-message"></p>
        </div>
        <div class="input-box">
          <input type="text" class="first" id="lastName" name="lastName" placeholder="Last Name"/>
          <p class="error-message"></p>
        </div>
      </div>

      <div class="input-box">
        <input type="text" class="first" id="username" name="username" placeholder="Username"/>
        <p class="error-message"></p>
      </div>

      <div class="input-box">
        <input type="email" class="first" id="email" name="email" placeholder="Email"/>
        <p class="error-message"></p>
      </div>

      <div class="password-container">
        <input type="password" id="password" name="password"  placeholder="Password"/>
        <span class="eye-span" onclick="togglePassword('password', this)">
          <i class="fas fa-eye toggle-password"></i>
        </span>
        <p class="error-message"></p>
      </div>

      <div class="password-container">
        <input type="password" id="confirmPassword"  name="confirmPassword" placeholder="Confirm Password"/>
        <span class="eye-span" onclick="togglePassword('confirmPassword', this)">
          <i class="fas fa-eye toggle-password"></i>
        </span>
        <p class="error-message"></p>
      </div>

      <div class="input-box">
        <input type="file" class="first" id="profileImage" name="profileImage" accept="image/*" />
        <p class="error-message"></p>
      </div>

      <button type="submit" name="signup">Sign Up</button>

      <div class="toggle-form">
        Already have an account? <a href="signin.php">Sign In</a>
      </div>
    </form>
  </div>

  <script src="assets/js/java.js"></script>
</body>
</html>
