$(document).ready(()=>{

    const $calendar = $(".calendar"),
    $date = $(".date"),
    $daysContainer = $(".days"),
    $prev = $(".prev"),
    $next = $(".next"),
    $todayBtn = $(".today-btn"),
    $gotoBtn = $(".goto-btn"),
    $dateInput = $(".date-input"),
    $eventDay = $(".event-day"),
    $eventDate = $(".event-date"),
    $eventsContainer = $(".events"),
    $addEventBtn = $(".add-event"),
    $addEventWrapper = $(".add-event-wrapper"),
    $addEventCloseBtn = $(".close"),
    $addEventTitle = $(".event-name"),
    $addEventFrom = $(".event-time-from"),
    $addEventTo = $(".event-time-to"),
    $addEventSubmit = $(".add-event-btn");
  
    let today = new Date()
    let activeDay;
    let month = today.getMonth();
    let year = today.getFullYear();

    const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ];

    const eventsArr = [];
    getEvents();
    
    function initCalendar(){
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const prevLastDay = new Date(year, month, 0);
        const prevDays = prevLastDay.getDate();
        const lastDate = lastDay.getDate();
        const day = firstDay.getDay();
        const nextDays = 7 - lastDay.getDay() - 1;
        
        $date.html(months[month] + " " + year);
        
        let days = "";
        
        for (let x = day; x > 0; x--) {
            days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
        }
        
        for (let i = 1; i <= lastDate; i++) {
            //check if event is present on that day
            let event = false;
            eventsArr.forEach((eventObj) => {
            if (
                eventObj.day === i &&
                eventObj.month === month + 1 &&
                eventObj.year === year
            ) {
                event = true;
            }
            });
            if (
            i === new Date().getDate() &&
            year === new Date().getFullYear() &&
            month === new Date().getMonth()
            ) {
            activeDay = i;
            getActiveDay(i);
            updateEvents(i);
            if (event) {
                days += `<div class="day today active event">${i}</div>`;
            } else {
                days += `<div class="day today active">${i}</div>`;
            }
            } else {
            if (event) {
                days += `<div class="day event">${i}</div>`;
            } else {
                days += `<div class="day ">${i}</div>`;
            }
            }
        }
        
        for (let j = 1; j <= nextDays; j++) {
            days += `<div class="day next-date">${j}</div>`;
        }
        $daysContainer.html(days);
        addListner();
        
    }

    function getActiveDay(date)
    {
        const day = new Date(year, month, date);
        const dayName = day.toString().split(" ")[0];

        $eventDay.html(dayName);
        $eventDate.html(date + " " + months[month] + " " + year);
    }

    $prev.on("click", prevMonth);
    $next.on("click", nextMonth);
    initCalendar();

    $todayBtn.on("click", function() {
        const today = new Date();
        month = today.getMonth();
        year = today.getFullYear();
        initCalendar();
      });


    $dateInput.on("input", (e)=>{
        $(this).val($(this).val().replace(/[^0-9/]/g, ""));
  
        if ($(this).val().length === 2) {
            $(this).val($(this).val() + "/");
        }
        
        if ($(this).val().length > 7) {
            $(this).val($(this).val().slice(0, 7));
        }
        
        if (e.inputType === "deleteContentBackward") {
            if ($(this).val().length === 3) {
            $(this).val($(this).val().slice(0, 2));
            }
        }
    })

 
    
    $gotoBtn.on("click", gotoDate);

    $addEventBtn.on("click", ()=>{
        $addEventWrapper.toggleClass("active");
    })



    $addEventCloseBtn.on("click", () => {
        $addEventWrapper.removeClass("active");
      });

    $(document).on("click", (e) => {
        if (!$(e.target).is($addEventBtn) && !$.contains($addEventWrapper[0], e.target)) {
          $addEventWrapper.removeClass("active");
        }
      });


    $addEventTitle.on("input", function() {
        $(this).val($(this).val().slice(0, 60));
    });
    


    $addEventFrom.on("input", function() {
        $(this).val($(this).val().replace(/[^0-9:]/g, ""));
        
        if ($(this).val().length === 2) {
          $(this).val($(this).val() + ":");
        }
        
        if ($(this).val().length > 5) {
          $(this).val($(this).val().slice(0, 5));
        }
      });


    $addEventTo.on("input", function() {
    $(this).val($(this).val().replace(/[^0-9:]/g, ""));
    
    if ($(this).val().length === 2) {
        $(this).val($(this).val() + ":");
    }
    
    if ($(this).val().length > 5) {
        $(this).val($(this).val().slice(0, 5));
    }
    });


    $addEventSubmit.on("click",  () => {
        const eventTitle = $addEventTitle.val();

        const eventTimeFrom =$addEventFrom.val();
        const eventTimeTo = $addEventTo.val();

        if (eventTitle === "" || eventTimeFrom === "" || eventTimeTo === "") {
            alert('Please fill all the fields');
            return;
        }
      
        //check correct time format 24 hour
        const timeFromArr = eventTimeFrom.split(":");
        const timeToArr = eventTimeTo.split(":");
        if (
          timeFromArr.length !== 2 ||
          timeToArr.length !== 2 ||
          timeFromArr[0] > 23 ||
          timeFromArr[1] > 59 ||
          timeToArr[0] > 23 ||
          timeToArr[1] > 59
        ) {
          alert("Invalid Time Format");
          return;
        }
      
        const timeFrom = convertTime(eventTimeFrom);
        const timeTo = convertTime(eventTimeTo);
      
        //check if event is already added
        let eventExist = false;

        $.each(eventsArr, function(index, event) {
            if (
            event.day === activeDay &&
            event.month === month + 1 &&
            event.year === year
            ) {
            $.each(event.events, function(index, event) {
                if (event.title === eventTitle) {
                eventExist = true;
                return false; // break out of loop
                }
            });
            }
            if (eventExist) return false; // break out of loop
        });

        if (eventExist) {
          alert("Event already added");
          return;
        }
        const newEvent = {
          title: eventTitle,
          time: timeFrom + " - " + timeTo,
        };
      
        let eventAdded = false;
        if (eventsArr.length > 0) {
            $.each(eventsArr, function(index, item) {
                if (
                    item.day === activeDay &&
                    item.month === month + 1 &&
                    item.year === year
                ) {
                    item.events.push(newEvent);
                    eventAdded = true;
                    return false; // break out of loop
                }
            });
        }
      
        if (!eventAdded) {
          eventsArr.push({
            day: activeDay,
            month: month + 1,
            year: year,
            events: [newEvent],
          });
        }
      
        // console.log(eventsArr);
        $addEventWrapper.removeClass("active");
        $addEventTitle.val(""); 
        $addEventFrom.val("");
        $addEventTo.val("");
        updateEvents(activeDay);
        //select active day and add event class if not added
        const activeDayEl = $(".day.active");
        if (!activeDayEl.hasClass("event")) {
          activeDayEl.addClass("event");
        }
      });
    

    $eventsContainer.on("click", ".event", function(e) {
        if ($(this).hasClass("event")) {
            alert("ádfasd")
            if (confirm("Are you sure you want to delete this event?")) {
                const eventTitle = $(this).find(".event-title").text();
                $.each(eventsArr, function(index, event) {
                    if (
                    event.day === activeDay &&
                    event.month === month + 1 &&
                    event.year === year
                    ) {
                    $.each(event.events, function(index, item) {
                        if (item.title === eventTitle) {
                        event.events.splice(index, 1);
                        }
                    });
                    // If no events left in a day then remove that day from eventsArr
                    if (event.events.length === 0) {
                        eventsArr.splice(index, 1);
                        // Remove event class from day
                        const activeDayEl = $(".day.active");
                        if (activeDayEl.hasClass("event")) {
                            activeDayEl.removeClass("event");
                        }
                    }
                    }
                });
                updateEvents(activeDay);
            }
        }
    });


    function saveEvents() {
        localStorage.setItem("events", JSON.stringify(eventsArr));
    }

    function prevMonth(){
        month--;
        if (month < 0) {
          month = 11;
          year--;
        }
        initCalendar();
    }
    
    function nextMonth() {
        month++;
        if (month > 11) {
          month = 0;
          year++;
        }
        initCalendar();
    }
    
    
    function getEvents() {
        // Check if events are already saved in local storage
        if (localStorage.getItem("events") === null) {
          return;
        }
        
        // Parse the events from localStorage and push them into eventsArr
        eventsArr.push(...JSON.parse(localStorage.getItem("events")));
      }
    
    
    function updateEvents(date) {
        let events = "";
        eventsArr.forEach((event) => {
          if (
            date === event.day &&
            month + 1 === event.month &&
            year === event.year
          ) {
            event.events.forEach((event) => {
              events += `<div class="event">
                  <div class="title">
                    <i class="fas fa-circle"></i>
                    <h3 class="event-title">${event.title}</h3>
                  </div>
                  <div class="event-time">
                    <span class="event-time">${event.time}</span>
                  </div>
              </div>`;
            });
          }
        });
        if (events === "") {
          events = `<div class="no-event">
                  <h3>No Events</h3>
              </div>`;
        }
        $eventsContainer.html(events);
        saveEvents();
    }
      
    
    function addListner() {
        $(".day").on("click", function(e) {
          const $clickedDay = $(this);
          getActiveDay($clickedDay.text());
          updateEvents(Number($clickedDay.text()));
          activeDay = Number($clickedDay.text());
      
          // Remove active class from all days
          $(".day").removeClass("active");
      
          // Add active class to clicked day
          $clickedDay.addClass("active");
      
          // If clicked on prev-date or next-date, switch to that month
          if ($clickedDay.hasClass("prev-date")) {
            prevMonth();
      
            // Add active to clicked day after month is changed
            setTimeout(function() {
              $(".day:not(.prev-date)").each(function() {
                if ($(this).text() === $clickedDay.text()) {
                  $(this).addClass("active");
                }
              });
            }, 100);
          } else if ($clickedDay.hasClass("next-date")) {
            nextMonth();
      
            // Add active to clicked day after month is changed
            setTimeout(function() {
              $(".day:not(.next-date)").each(function() {
                if ($(this).text() === $clickedDay.text()) {
                  $(this).addClass("active");
                }
              });
            }, 100);
          }
        });
      }
    
    
    function gotoDate() {
        // console.log("here");
        const dateArr = $dateInput.val().split("/");
        if (dateArr.length === 2) {
            if (dateArr[0] > 0 && dateArr[0] < 13 && dateArr[1].length === 4) {
                month = dateArr[0] - 1;
                year = dateArr[1];
                initCalendar();
                return;
            }
        }
        alert("Invalid Date");
    }

    function convertTime(time) {
        //convert time to 24 hour format
        let timeArr = time.split(":");
        let timeHour = timeArr[0];
        let timeMin = timeArr[1];
        let timeFormat = timeHour >= 12 ? "PM" : "AM";
        timeHour = timeHour % 12 || 12;
        time = timeHour + ":" + timeMin + " " + timeFormat;
        return time;
      }
})




