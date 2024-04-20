<?php
include "../config/database.php";


if (isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['Cpassword'])) {
    $name = $_POST['name'];
    $pwd = $_POST['password'];
    $email = $_POST['email'];
    $cpwd = $_POST['Cpassword'];

    if (empty($name)) {
        $_SESSION['signup'] = 'Please enter your name';
    }
    else if(!preg_match("/^[a-zA-Z-' ]*$/",$name)){
        $_SESSION['signup'] = "Only letters and white space allowed";
    }
    else if (empty($email)) {
        $_SESSION['signup'] = 'Please enter your email address';
    }

    if(isset($_SESSION['signup'])){
        header("Location: ./AccsessPage.php");
        exit;
    }

    if ($cpwd === $pwd) {

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Sanitize input
        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['signup'] = "Invalid email format";
            header("Location: ./AccsessPage.php");
            exit;
        }

        $check = "SELECT COUNT(*) as count FROM Users WHERE email='$email'";
        $result_check = $conn->query($check);
        if ($result_check && $result_check->fetch_assoc()['count'] > 0) {
            $_SESSION['signup'] = "Email already exists";
            header("Location: ./AccsessPage.php");

            exit;
        }

        // Hash password
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        // Move Img IN LOCAL;
        if ($_FILES['avatar']['error'] != UPLOAD_ERR_OK) {
            $img_name = "avatar.jpeg";
        }
        else{
            $img_name =  $_FILES['avatar']['name'];
            $img_destination_path = '../imgs/' . $img_name;
            $img_tmp_name = $_FILES['avatar']['tmp_name'];
    
            move_uploaded_file($img_tmp_name, $img_destination_path);
        }
        // Prepare and execute SQL statement
        $sql = "INSERT INTO users (Username, email, pwd, avatar) VALUES ('$name', '$email', '$pwd', '$img_name')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['signup-success'] = "Registration successful. Please log in";
            header("Location: ./AccsessPage.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
    } else {
        $_SESSION['signup'] = "Passwords do not match";
        header("Location: ./AccsessPage.php");
    }
}
