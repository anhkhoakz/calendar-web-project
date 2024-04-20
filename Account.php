<?php
include "./config/database.php";

function selectIdByEmail($email, $conn)
{
    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    return $row['Userid'];
}


function selectAvatarByEmail($email, $conn)
{
    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    return $row['avatar'] ;
}


function selectUser($email, $conn)
{
    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    return $row;
}

function changePassword($email, $pass, $newPass, $conn) {
    $sql = "SELECT * FROM users WHERE email = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!password_verify($pass, $row["pwd"])) {
        $_SESSION["changePass"] = "Password incorrect";
    } else {
        $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET pwd = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashedNewPass, $email);
        if (!$stmt->execute()) {
            echo "Execute failed: " . $stmt->error;
        } else {
            $_SESSION["changePassSuccess"] =  "Change password successfully!";
        }
    }
}


function updateUser($email,$userName, $avatar, $password,$conn){
    
    $row = selectUser($email, $conn);

    if (!password_verify($password, $row["pwd"])) {
        $_SESSION["updateUser"] = "Password incorrect";
    }
    else{

        $sql = "UPDATE users SET Username = ?, avatar = ? WHERE email = ?";


        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sss", $userName, $avatar, $email);
    
        if( !$stmt->execute()){
            $_SESSION["updateUser"] = ("Execute failed: " . $stmt->error);
            exit;
        }
        $_SESSION["updateUserSuccess"] = "Update Infomation successfully!";
    }
}



