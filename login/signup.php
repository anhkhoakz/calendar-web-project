<?php
include "../config/database.php";
if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['Cpassword'])) {
    $name = $_POST['name'];
    $pwd = $_POST['password'];
    $email = $_POST['email'];
    $cpwd = $_POST['Cpassword'];

    if($cpwd === $pwd) {
        
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

        // Prepare and execute SQL statement
        $sql = "INSERT INTO users (Username, email, pwd) VALUES ('$name', '$email', '$pwd')";
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

?>
