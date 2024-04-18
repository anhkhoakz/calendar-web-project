<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  include "./Account.php";


    $date = $_POST['eventDate'];
    $userId = selectIdByEmail($_SESSION['user_email'], $conn);;

    $sql = "select * from events where Eventday=$date and Userid=$userId";

    $result = $conn -> query($sql);

    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
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
    }
    else{
        echo "<div class='no-event'><h3>No Events</h3></div>";
    }
}

?>