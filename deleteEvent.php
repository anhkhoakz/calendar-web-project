<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./Account.php";
    
    $event_name = $_POST["eventName"];
    $userEmail = selectIdByEmail($_SESSION['user_email'], $conn);
    $eventDate = $_POST["eventDate"];

    $sql = "Delete from events where Eventname= ? and Userid=? and Eventday=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $event_name, $userEmail, $eventDate);
    
    if ($stmt->execute()) {
       echo "delete successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Invalid request method.";
}

?>
