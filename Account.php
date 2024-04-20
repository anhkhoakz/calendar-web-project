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



function selectUserForUpdateByEmail($email, $conn)
{
    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    return array ($row['Username'] , $row['avatar']);
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


function updateUser($userName, $avatar, $conn){
    $sql = "UPDATE users SET Username = ? and avatar = ? WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $userName, $avatar);
   
    if( !$stmt->execute()){
         echo ("Execute failed: " . $stmt->error);
         exit;
    }
    echo "Update Infomation successfully!";
}


