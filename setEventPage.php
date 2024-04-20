<?php
include "./Account.php";

if (!isset($_SESSION['user_email'])) {
  header("location: ./login/AccsessPage.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Stay organized with our user-friendly Calendar featuring events, reminders, and a customizable interface. Built with HTML, CSS, and JavaScript. Start scheduling today!" />
  <meta name="keywords" content="calendar, events, reminders, javascript, html, css, open source coding" />
  
  <?php
  include './partials/head.php';
  ?>

  <link rel="stylesheet" href="style.css" />
  
  <title>Calendar with Events</title>

</head>

<body>
  <?php include "./partials/header.php" ?> 
  
  <div class="body">
    
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
                  <input name="event" type="text" placeholder="Event Name" class="event-name" value=""/>
                </div>
                <div class="add-event-input">
                  <input type="text" placeholder="Event Time From" class="event-time-from" name="eventstart" value=""/>
                </div>
                <div class="add-event-input">
                  <input type="text" placeholder="Event Time To" class="event-time-to" name="eventfinished" value="" />
                </div>
                  <input type="hidden"  name="eventDate" id='getEventDate' value=""/>
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

  </div>
  
  <?php include './partials/footer.php' ?>

  <script src="./script.js"> </script>
</body>

</html>