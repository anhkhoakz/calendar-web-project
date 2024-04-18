<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./Account.php";
    
    $event_name = $_POST["event"];
    $event_start_date = $_POST["eventstart"];
    $event_end_date = $_POST["eventfinished"];
    $userEmail = selectIdByEmail($_SESSION['user_email'], $conn);
    $eventDate = $_POST["getEventDate"];

    $sql = "SELECT * FROM events WHERE Eventday='$eventDate' AND Userid='$userEmail' AND timestart<'$event_start_date' AND timefinish>'$event_start_date'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0){
      echo "exist event in this time";
      exit;
    }


    $sql = "INSERT INTO events (Eventname, timestart, timefinish, Eventday, Userid) VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $event_name, $event_start_date, $event_end_date, $eventDate, $userEmail);
    
    if ($stmt->execute()) {
        $sql = "SELECT * FROM events WHERE Eventday='$eventDate' AND Userid='$userEmail' AND Eventname='$event_name'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();  
    
        echo 
        "<div class='event'>
        <div class='title'>
          <i class='fas fa-circle'></i>
          <h3 class='event-title'>". $row['Eventname'] ."</h3>
        </div>
        <div class='event-time'>
          <span class='event-time'>". $row['timestart'] ." - ". $row['timefinish'] ."</span>
        </div>
            </div>";
    }
        
    else {
        echo "Error";
    }
    
    $stmt->close();
} else {
    echo "Invalid request method.";
}

?>
