<?php
include "./eventDb.php";

if(isset($_POST['updateEvent'])){

    $dateString = empty($_POST['eventDay'])? $_POST['eventOldDay'] : $_POST['eventDay'];

    $eventDate = "";

    if($dateString ==  $_POST['eventDay'])
    {
        $date = new DateTime($dateString);
    
        
        $eventDate = $date->format('d F Y');
    }
    else
        $eventDate = $dateString;

    $event_name = $_POST['eventname'];
    $event_start_date = $_POST['timefrom'];
    $event_end_date = $_POST['timeto'];

    $event_old_name = $_POST['eventOldName'];
    $event_old_start = $_POST['eventOldStart'];
    $event_old_date = $_POST['eventOldDay'];

    updateEvent($event_name, $event_start_date, $event_end_date, $eventDate,$event_old_name, $event_old_start, $event_old_date, $conn);
}

$events = selectAllEvents($conn);

list($getEventsNotStart, $getEventsFinish) = selectAllEventsByStatus($conn);

if (isset($_GET['status'])) {
    if ($_GET['status'] == 'finished')
        $events = $getEventsFinish;

    else if ($_GET['status'] == 'notstart')
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

        <div class="mb-4">
            <a href="<?= ROOT_URL ?>" type="button" class="btn btn-secondary">All Events</a>
            <a href="<?= ROOT_URL . "?status=finished" ?>" type="button" class="btn btn-primary">Events are over</a>
            <a href="<?= ROOT_URL . "?status=notstart" ?>" type="button" class="btn btn-secondary">Upcoming events</a>
        </div>

        <?php

            if(isset($_SESSION['updateEvent'])){
                echo "<div class='alert alert-danger' >".$_SESSION['updateEvent'] ."</div>";
                unset($_SESSION['updateEvent']);
            }

            if(isset($_SESSION['updateEventSuccess'])){
                echo "<div class='alert alert-success' >".$_SESSION['updateEventSuccess'] ."</div>";
                unset($_SESSION['updateEventSuccess']);
            }
        ?>
        
        <table class="table table-striped text-center">
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
                    <tr class="item">
                        <th scope="col"><?= $id  ?></th>
                        <td class="align-middle"><?= $eventName ?></td>
                        <td class="align-middle"><?= $eventGetDate ?></td>
                        <td class="align-middle"><?= $eventStart ?></td>
                        <td class="align-middle"><?= $eventFinish ?></td>
                        <td class="<?= $text ?> align-middle"><?= $status ?></td>

                        <td class="align-middle">
                            <?php if ($status == "not started") : ?>
                                <button type="button" class="btn btn-sm btn-primary edit-btn mr-1"  data-bs-toggle="modal" data-bs-target="#editModal<?= $id ?>"><i class="far fa-edit"></i></button>
                            <?php endif; ?>
                            <button type="button" class="btn btn-sm  btn-danger delete-btn"  data-bs-toggle="modal" data-bs-target="#deleteModal<?= $id ?>"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>

                    <div id="deleteModal<?= $id ?>" class="modal fade" role="dialog" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <hp class="modal-title">Delete a Product</hp>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete <strong><?= $eventName ?></strong> ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>                                    
                                    <button id="deleteEvent" type="button" class="btn btn-sm btn-danger" onclick="deleteEvent('<?= $eventName ?>', '<?= $eventGetDate ?>')">Delete</button>

                                </div>

                            </div>

                        </div>
                    </div>
                    

                    <div id="editModal<?= $id ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="" method="post">
                                    <div class="modal-header">
                                        <hp class="modal-title"><strong>Update event</strong></hp>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="eventname">Event Name</label>
                                            <input name="eventname" id="name" type="text" class="form-control" value="<?=$eventName?>"  >
                                        </div>
                                        <div class="form-group">
                                            <label for="timefrom">Time From</label>
                                            <input name="timefrom" id="timefrom" type="time" class="form-control"  value="<?=$eventStart?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="timeto">Time To</label>
                                            <input name="timeto" id="timeto" type="time" class="form-control" value="<?=$eventFinish?>" >
                                        </div>

                                        <div class="form-group">
                                            <label for="eventDay">Event Day</label>
                                            <input name="eventDay" id="eventDay" type="date" class="form-control" value="<?=$eventGetDate?>">
                                        </div>

                                        <input type="hidden" name="eventOldName" value="<?=$eventName?>">
                                        <input type="hidden" name="eventOldStart" value="<?=$eventStart?>">
                                        <input type="hidden" name="eventOldDay" value="<?=$eventGetDate?>">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button id="updateEvent" name='updateEvent' type="submit" class="btn btn-sm btn-success">Save</button>
                                    </div>
                                </form>
                            </div>
                    
                        </div>
                    </div>
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

    
    <script>
        function deleteEvent(eventName, eventDate) {
            console.log(eventName);
            $.ajax({
                url: "deleteEvent.php",
                method: "POST",
                data: { eventName: eventName, eventDate: eventDate },
                success: function (response) {
                    window.location.href = 'index.php';
                },
                error: function (xhr, status, error) {
                    alert('Something went wrong');
                }
            });
        };

    </script>

</body>

</html>