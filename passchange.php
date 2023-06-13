<?php
include 'connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the "password" key exists in the $_POST array
    if (isset($_POST['newpass'])) {
        // Get the new password and confirm password from the form
        $newPassword = $_POST['newpass'];
        $confirmPassword = $_POST['confirm_password'];

        // Check if the passwords match
        if ($newPassword !== $confirmPassword) {
            echo "Passwords don't match.";
            exit;
        }

        // Get the email from the session
        $email = $_SESSION['mail'];

        // Update the password in the database
        $query = "UPDATE faculty SET password = '$newPassword' WHERE email = '$email'";
        $result = mysqli_query($con, $query);

        if ($result) {
            // echo '<script>alert("Password changed successfully")</script>';
            $_SESSION['status']="Password Changed successfully";
        $_SESSION['status_code']="success";
            echo "  <script>
                window.location = 'login.php'
                  </script> ";
        } else {
            echo '<script>alert("Not updated")</script>';
        }
    } else {
        echo "Password field not found in the form data.";
        exit;
    }
} else {
    echo "Invalid request method.";
    exit;
}
?>
