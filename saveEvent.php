<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "./Account.php";

    $event_name = $_POST["event"];
    $event_start_date = $_POST["eventstart"];
    $event_end_date = $_POST["eventfinished"];
    $userEmail = selectIdByEmail($_SESSION['user_email'], $conn);
    $eventDate = $_POST["getEventDate"];


    $eventComponents = explode(' ', $eventDate);
    $year = $eventComponents[2];
    $day = $eventComponents[0];

    $monthAl = $eventComponents[1];
    $month;

    switch (strtolower($monthAl)) {
        case "january":
            $month = 1;
            break;
        case "february":
            $month = 2;
            break;
        case "march":
            $month = 3;
            break;
        case "april":
            $month = 4;
            break;
        case "may":
            $month = 5;
            break;
        case "june":
            $month = 6;
            break;
        case "july":
            $month = 7;
            break;
        case "august":
            $month = 8;
            break;
        case "september":
            $month = 9;
            break;
        case "october":
            $month = 10;
            break;
        case "november":
            $month = 11;
            break;
        case "december":
            $month = 12;
            break;
    }

    $timeFromArr = explode(':', $event_start_date);
    $timeToArr = explode(':', $event_end_date);


    $startHour = intval($timeFromArr[0]);
    $startMinute = intval($timeFromArr[1]);
    $endHour = intval($timeToArr[0]);
    $endMinute = intval($timeToArr[1]);


    if ($startHour > $endHour || ($startHour === $endHour && $startMinute >= $endMinute)) {
        echo ("The event start time must be earlier than the end time.");
        exit;
    }

    $now = getdate();
    $currentHour = $now['hours'];
    $currentMinute = $now['minutes'];
    $currentYear = $now['year'];
    $currentMonth = $now['mon'];
    $currentDay = $now['mday'];


    if (
        $currentYear > $year ||
        ($currentYear == $year && ($currentMonth > $month ||
            ($currentMonth == $month && ($currentDay > $day ||
                ($currentDay == $day && ($currentHour > $startHour ||
                    ($currentHour == $startHour && $currentMinute > $startMinute)))))))
    ) {
        echo "The event start time must be earlier than the current time.";
        exit;
    }

    $sql = "SELECT * FROM events WHERE Eventday='$eventDate' AND Userid='$userEmail' AND timestart<'$event_start_date' AND timefinish>'$event_start_date'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
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
          <h3 class='event-title'>" . $row['Eventname'] . "</h3>
        </div>
        <div class='event-time'>
          <span class='event-time'>" . $row['timestart'] . " - " . $row['timefinish'] . "</span>
        </div>
            </div>";
    } else {
        echo "Error";
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}
