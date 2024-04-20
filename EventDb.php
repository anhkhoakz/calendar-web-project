<?php

include "./Account.php";

function selectAllEvents($conn)
{

    $uId = selectIdByEmail($_SESSION['user_email'], $conn);
    $sql = "select * from events where Userid = $uId";
    $result = $conn->query($sql);
    $array = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $array[] = $row;
        }
    }

    return $array;
}


function selectAllEventsByStatus($conn)
{

    $uId = selectIdByEmail($_SESSION['user_email'], $conn);
    $sql = "select * from events where Userid = $uId";
    $result = $conn->query($sql);

    $eventsFinished = [];
    $eventsNotStarted = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $eventStart =  $row['timestart'];
            $eventFinish = $row['timefinish'];
            $eventGetDate =  $row['Eventday'];

            $eventComponents = explode(' ', $eventGetDate);
            $monthAl = $eventComponents[1];
            $month = 0;
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

            $year = $eventComponents[2];
            $day = $eventComponents[0];

            $dateInfo = getdate();
            $currentYear = $dateInfo['year'];
            $currentMonth = $dateInfo['mon'];
            $currentDay = $dateInfo['mday'];
            $currentHour = $dateInfo['hours'];
            $currentMinute = $dateInfo['minutes'];

            $startTimeComponents = explode(':', $eventStart);
            $eventStartHour = (int)$startTimeComponents[0];
            $eventStartMinute = (int)$startTimeComponents[1];

            $finishTimeComponents = explode(':', $eventFinish);
            $eventFinishHour = (int)$finishTimeComponents[0];
            $eventFinishMinute = (int)$finishTimeComponents[1];

            if (
                $currentYear < $year ||
                ($currentYear == $year && ($currentMonth < $month ||
                    ($currentMonth == $month && ($currentDay < $day ||
                        ($currentDay == $day && ($currentHour < $eventStartHour ||
                            ($currentHour == $eventStartHour && $currentMinute < $eventStartMinute)))))))
            ) {
                $eventsNotStarted[]  = $row;
            } elseif (
                $currentYear > $year ||
                ($currentYear == $year && ($currentMonth > $month ||
                    ($currentMonth == $month && ($currentDay > $day ||
                        ($currentDay == $day && ($currentHour > $eventFinishHour ||
                            ($currentHour == $eventFinishHour && $currentMinute > $eventFinishMinute)))))))
            ) {
                $eventsFinished[]  = $row;
            }
        }
    }

    return array($eventsNotStarted, $eventsFinished);
}


function updateEvent($event_name, $event_start_date, $event_end_date, $eventDate,$event_old_name, $event_old_start, $event_old_date, $conn){
    $userEmail = selectIdByEmail($_SESSION['user_email'], $conn);

    $eventComponents = explode(' ', $eventDate);
    $year = $eventComponents[2];
    $day = $eventComponents[0];

    $monthAl = $eventComponents[1];
    $month = 0;

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
        $_SESSION['updateEvent'] = ("The event start time must be earlier than the end time.") ;
        return;
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
        $_SESSION['updateEvent'] = "The event start time must be earlier than the current time." .$eventDate. " " . $now['year'] . $currentMonth . $currentDay;
        return;
    }

    $sql = "SELECT * FROM events WHERE Eventday='$eventDate' AND Userid='$userEmail' AND timestart<'$event_start_date' AND timefinish>'$event_start_date'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
     
    if(($result->num_rows == 1 && $row['Eventname'] == $event_old_name && $row['Eventday'] == $event_old_date && $row['timestart'] == $event_old_start) || $result->num_rows == 0 ){

        $sql = "UPDATE events  SET Eventname = ?, timestart = ?, timefinish = ?, Eventday = ? WHERE Userid = ? and Eventday = ? and timestart = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $event_name, $event_start_date, $event_end_date, $eventDate, $userEmail, $event_old_date, $event_old_start);
    
        if ($stmt->execute()) {
            $_SESSION['updateEventSuccess']  = "Update Event Successfully!";
            return;
        } else {
            $_SESSION['updateEvent']  = "Error"; 
            return;

        }
        $stmt->close();
    }
    else{
        $_SESSION['updateEvent'] =  "exist event in this time";
        return;
    }
    
}