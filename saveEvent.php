<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./Account.php";
    
    $event_name = $_POST["event"];
    $event_start_date = $_POST["eventstart"];
    $event_end_date = $_POST["eventfinished"];
    $userEmail = selectIdByEmail($_SESSION['user_email'], $conn);
    $eventDate = $_POST["getEventDate"];

    $sql = "INSERT INTO events (Eventname, timestart, timefinish, Eventday, Userid) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $event_name, $event_start_date, $event_end_date, $eventDate, $userEmail);
    
    if ($stmt->execute()) {
       header("location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    echo "Invalid request method.";
}

?>
