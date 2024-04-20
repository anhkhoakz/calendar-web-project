<?php
include "./eventDb.php";
$events = selectAllEvents($conn);

list($getEventsNotStart,$getEventsFinish) = selectAllEventsByStatus($conn);

if(isset($_GET['status']) ){
    if($_GET['status']=='finished')
        $events = $getEventsFinish;

    else if($_GET['status']=='notstart')
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

    <a href="<?= ROOT_URL?>" type="button" class="btn btn-secondary">All Events</a>
    <a href="<?= ROOT_URL . "?status=finished"?>" type="button" class="btn btn-primary">Events are over</a>
    <a href="<?= ROOT_URL . "?status=notstart"?>" type="button" class="btn btn-secondary">Upcoming events</a>

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


<<<<<<< HEAD
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
=======
  <?php include "./partials/header.php" ?>


  <div class="container1">
    <div class="left">
      <div class="calendar">
        <div class="month">
          <i class="fas fa-angle-left prev"></i>
          <div class="date">december 2015</div>
          <i class="fas fa-angle-right next"></i>
        </div>
        <div class="weekdays">
          <div>Sun</div>
          <div>Mon</div>
          <div>Tue</div>
          <div>Wed</div>
          <div>Thu</div>
          <div>Fri</div>
          <div>Sat</div>
        </div>
        <div class="days"></div>
        <div class="goto-today">
          <div class="goto">
            <input type="month" placeholder="mm/yyyy" class="date-input" />
            <button class="goto-btn">Go</button>
          </div>
          <button class="today-btn">Today</button>
        </div>
      </div>
    </div>
    <div class="right">
      <div class="today-date">
        <div class="event-day">Tue</div>
        <div class="event-date">19 April 2024</div>
      </div>
      <div class="events">
        <div class="event">
          <div class="title">
            <i class="fas fa-circle"></i>
            <h3 class="event-title">di choi</h3>
          </div>
          <div class="event-time">
            <span class="event-time"></span>
          </div>
        </div>

      </div>
      <form id="formAddEvent" class="add-event-wrapper" method="POST">
        <div class="add-event-header">
          <div class="title">Add Event</div>
          <i class="fas fa-times close"></i>
        </div>
        <div class="add-event-body">
          <div class="add-event-input">
            <input name="event" type="text" placeholder="Event Name" class="event-name" value="" />
          </div>
          <div class="add-event-input">
            <input type="text" placeholder="Event Time From" class="event-time-from" name="eventstart" value="" />
          </div>
          <div class="add-event-input">
            <input type="text" placeholder="Event Time To" class="event-time-to" name="eventfinished" value="" />
          </div>
          <input type="hidden" name="eventDate" id='getEventDate' value="" />
        </div>

        <div class="add-event-footer">
          <button type="submit" class="add-event-btn">Add Event</button>
        </div>
      </form>
    </div>
    <button class="add-event">
      <i class="fas fa-plus"></i>
    </button>
  </div>
>>>>>>> 3ea89847c59f488dcfb364291ddae42af0bda47d


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
                    <td class="<?=$text?>"><?= $status ?></td>
                    <!-- <td><?= $currentHour ?></td> -->
                </tr>

            <?php
            }
            ?>
        </tbody>

      
    </table>

    <?php
            if(count($events) == 0){
                ?>
                <div class="mt-5 pt-5" style="text-align:center;color: #878895;"><h2>No Event</h2></div>
        <?php
            }
        ?>

</div>

</body>

</html>