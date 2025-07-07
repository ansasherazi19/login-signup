<?php 
include ("include/header.php");
require("include/connection.php");

if (isset($_POST['resetpass']) && $_SERVER['REQUEST_METHOD'] == "POST") {
  $password = mysqli_real_escape_string($connection, $_POST['newPassword']);
  $cpassword = mysqli_real_escape_string($connection, $_POST['confirmNewPassword']);

  $token = isset($_GET['reset_token']) ? $_GET['reset_token'] : '';
  $email = isset($_GET['email']) ? $_GET['email'] : '';

  $check = "SELECT * FROM `users` WHERE `email`='$email' AND `reset_token`='$token'";
  $result = mysqli_query($connection, $check);

  if (mysqli_num_rows($result) > 0) {
    if (!empty($password) && !empty($cpassword) && $password === $cpassword) {
      $newtoken = md5(rand());
      $hashpass = password_hash($password, PASSWORD_BCRYPT);

      $updatePass = "UPDATE `users` SET `password_hash`='$hashpass', `reset_token`='$newtoken' WHERE `email`='$email'";
      $updatePass_run = mysqli_query($connection, $updatePass);

      if ($updatePass_run) {
        echo "<script>
                alert('Your password has been updated. You can now login with your new password');
                window.location.href='signin.php';
              </script>";
      } else {
        echo "<script>alert('Something went wrong. Please try again later.');</script>";
      }
    } else {
      echo "<script>alert('Passwords should match and must not be empty.');</script>";
    }
  } else {
    echo "<script>
            alert('Invalid or expired token.');
            window.location.href='signin.php';
          </script>";
  }
}
?>

<body>
<div class="form-container reset-password-container">
  <form id="resetForm" action="" method="POST">
    <h1>Reset Password</h1>
    <p class="info-text">Create a new password for your account.</p>

    <div class="password-container">
      <input type="password" name="newPassword" placeholder="Password" id="newPassword" required />
      <span class="eye-span" onclick="togglePassword('newPassword', this)">
        <i class="fas fa-eye toggle-password"></i>
      </span>
      <p class="error-message"></p>
    </div>

    <div class="password-container">
      <input type="password" name="confirmNewPassword" placeholder="Confirm Password" id="confirmNewPassword" required />
      <span class="eye-span" onclick="togglePassword('confirmNewPassword', this)">
        <i class="fas fa-eye toggle-password"></i>
      </span>
      <p class="error-message"></p>
    </div>

    <button type="submit" name="resetpass">Update Password</button>
  </form>

  <div class="toggle-form">
    <a href="signin.php">Back to Sign In</a>
  </div>
</div>

<script src="assets/js/java.js"></script>
</body>
</html>
