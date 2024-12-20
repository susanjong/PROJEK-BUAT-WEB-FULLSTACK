<?php
session_start(); // Start the session at the very top
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check email, and password are set
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if the user exists by email
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password and proceed to login if correct
        if ($user && password_verify($password, $user['password'])) {
            // Set session variable
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            // Check if the email matches the admin's email
            if ($email === 'fathur.6913@gmail.com') {
                // Redirect to the admin panel for the specific user
                header("Location: /adminpanel.php");
            } else {
                // Redirect to homepage for regular users
                header("Location: /PROJEK%20AKHIR_PEMWEB/PROJEK%20PEMWEB%20AKHIR/tampilan%20awal/film.html");
            }

            exit(); // Stop the script after redirecting
        } else {
            // Handle invalid login
            header("Location: /PROJEK%20AKHIR_PEMWEB/PROJEK%20PEMWEB%20AKHIR/sign_form/sign.html?error=invalid_credentials");
            exit();
        }
    }
}
?>