<?php
include "../config/database.php";

<<<<<<< HEAD
if(isset($_POST['password']) && isset($_POST['email'])) {
=======


if (isset($_POST['password']) && isset($_POST['email'])) {
>>>>>>> 3ea89847c59f488dcfb364291ddae42af0bda47d
    $pwd = $_POST['password'];
    $email = $_POST['email'];


    $email = $conn->real_escape_string($email);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['signin'] = "Invalid email format";
        exit;
    }

    // Prepare SQL statement
    $sql = "SELECT * FROM Users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User with this email exists, now verify password
        $row = $result->fetch_assoc();
        $stored_hash = $row['pwd'];

        // Verify password
        if (password_verify($pwd, $stored_hash)) {
            $_SESSION['user_email'] = $email;
            header("Location: " . ROOT_URL);
            exit;
        } else {
            $_SESSION['signin'] = "Login failed: Incorrect password";
            header("location: " . ROOT_URL . "./login/AccsessPage.php");
            exit;
        }
    } else {
        $_SESSION['signin'] = "Login failed: User not found";
        header("location: " . ROOT_URL . "./login/AccsessPage.php");
        exit;
    }

    // Close connection
    $conn->close();
}
