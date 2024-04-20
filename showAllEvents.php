<?php
include "./EventDb.php";
$events = selectAllEvents($conn);

list($getEventsNotStart, $getEventsFinish) = selectAllEventsByStatus($conn);

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'finished')
        $events = $getEventsFinish;

    else if ($_GET['status'] == 'notstarted')
        $events = $getEventsNotStart;
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

    <?php include "./partials/header.php" ?>

    <div class="container">

        <a href="showAllEvents.php" type="button" class="btn btn-secondary">All Events</a>
        <a href="showAllEvents.php?status=finished" type="button" class="btn btn-primary">Events are over</a>
        <a href="showAllEvents.php?status=notstarted" type="button" class="btn btn-secondary">Upcoming events</a>

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
                    $text = '';

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
                        $text = "text-danger";
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
                        $text = "text-success";
                    }
                    // Case 3: Event is ongoing
                    else {
                        $status = "ongoing";
                        $text = "text-warning";
                    }

                ?>
                    <tr>
                        <th scope="col"><?= $id  ?></th>
                        <td><?= $eventName ?></td>
                        <td><?= $eventGetDate ?></td>
                        <td><?= $eventStart ?></td>
                        <td><?= $eventFinish ?></td>
                        <td class="<?= $text ?>"><?= $status ?></td>
                        <!-- <td><?= $currentHour ?></td> -->
                    </tr>

                <?php
                }
                ?>
            </tbody>


        </table>

        <?php
        if (count($events) == 0) {
        ?>
            <div class="mt-5 pt-5" style="text-align:center;color: #878895;">
                <h2>No Event</h2>
            </div>
        <?php
        }
        ?>

    </div>

</body>

</html>