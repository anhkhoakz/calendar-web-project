<?php

include "./Account.php";

function selectAllEvents($conn)
{

    $uId = selectIdByEmail($_SESSION['user_email'], $conn);
    $sql = "select * from events where Userid = $uId";
    $result = $conn -> query($sql);

    $array = [];

    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
            $array[] = $row;
        }
    }

    return $array;
}


function selectAllEventsByStatus($conn){

    $uId = selectIdByEmail($_SESSION['user_email'], $conn);
    $sql = "select * from events where Userid = $uId";
    $result = $conn -> query($sql);

    $eventsFinished = [];
    $eventsNotStarted = [];

    if($result->num_rows > 0){
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

?>