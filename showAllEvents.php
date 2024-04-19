<?php
include "./EventDb.php";
$events = selectAllEvents($conn);

    // $getEventsFinish = selectAllEventsByStatus;
$getEventsNotStart = [];
if(isset($_GET['status']) ){
    if($_GET['status']=='finished')
        $events = $getEventsFinish;

    else if($_GET['status']=='finished')
        $event = $getEventsNotStart;
    
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include "./partials/head.php"; ?>
</head>

<body>

<?php include"./partials/header.php" ?>

<a href="showAllEvents.php?status=finished" type="button" class="btn btn-primary">Primary</a>
<a href="showAllEvents.php?status=notstarted" type="button" class="btn btn-secondary">Secondary</a>
<a href="showAllEvents.php?status= " type="button" class="btn btn-success">Success</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Event name</th>
                <th scope="col">Day</th>
                <th scope="col">Time start</th>
                <th scope="col">Time end</th>
                <th scope="col">Status</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $id = 0;
            foreach ($events as $event) {
                $id++;
                $eventName =  $event['Eventname'];
                $eventStart =  $event['timestart'];
                $eventFinish = $event['timefinish'];
                $eventGetDate =  $event['Eventday'];
                $status = "";

                $eventComponents = explode(' ', $eventGetDate);
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
                    $status = "not started";
                }
                // Case 2: Event has already finished
                elseif (
                    $currentYear > $year ||
                    ($currentYear == $year && ($currentMonth > $month ||
                        ($currentMonth == $month && ($currentDay > $day ||
                            ($currentDay == $day && ($currentHour > $eventFinishHour ||
                                ($currentHour == $eventFinishHour && $currentMinute > $eventFinishMinute)))))))
                ) {
                    $status = "finished";
                }
                // Case 3: Event is ongoing
                else {
                    $status = "ongoing";
                }

            ?>
                <tr>
                    <th scope="col"><?= $id  ?></th>
                    <td><?= $eventName ?></td>
                    <td><?= $eventGetDate ?></td>
                    <td><?= $eventStart ?></td>
                    <td><?= $eventFinish ?></td>
                    <td><?= $status ?></td>
                    <td><?= $currentHour ?></td>

                </tr>

            <?php
            }
            ?>
        </tbody>
    </table>

</body>

</html>