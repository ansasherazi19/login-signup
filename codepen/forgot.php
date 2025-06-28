<?php 
include("include/header.php");
require("include/connection.php");

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendRecoveryLink($token, $email, $username) {
    require 'vendor/autoload.php';
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ansasherazi14@gmail.com';
        $mail->Password   = 'trzc ihez dtfp zizm'; // App password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->setFrom('ansasherazi14@gmail.com', 'The CODERS');
        $mail->addAddress($email, $username);
        $mail->isHTML(true);
        $mail->Subject = 'PASSWORD RECOVERY REQUEST';
        $mail->Body    = 'A request has been generated to reset your password. Please <b><a href="http://localhost/codepen/reset.php?reset_token='.$token.'&email='.$email.'">Click here</a></b> to reset your password.';
        $mail->send();
        echo "<script>alert('Email has been sent to $email. Please check your inbox');</script>";
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

// Handle form submission
if (isset($_POST['sendlink']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $email = mysqli_real_escape_string($connection, $_POST['recoveryemail']);
    $token = md5(rand());
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connection, $check);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
        $update = "UPDATE users SET reset_token='$token' WHERE email='$email'";
        if (mysqli_query($connection, $update)) {
            sendRecoveryLink($token, $email, $username);
        }
    } else {
        echo "<script>alert('Please create an account first.'); window.location.href='signup.php';</script>";
    }
}
?>

<body>
<div class="form-container forgot-password-container">
  <form action="forgot.php" method="POST" id="forgetForm">
    <h1>Forgot Password?</h1>
    <p class="info-text">Enter your email address and we'll send you a link to reset your password.</p>
    <div class="input-box">
      <input type="email"  class="first" name="recoveryemail" id="recoveryemail" placeholder="Email" required />
      <p class="error-message"></p>
    </div>
    <button type="submit" name="sendlink">Send Reset Link</button>
  </form>
  <div class="toggle-form">
    Remember your password? <a href="signin.php">Sign In</a>
  </div>
</div>

<script src="assets/js/java.js"></script>
</body>
</html>
