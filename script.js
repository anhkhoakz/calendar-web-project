const calendar = document.querySelector(".calendar"),
  date = document.querySelector(".date"),
  daysContainer = document.querySelector(".days"),
  prev = document.querySelector(".prev"),
  next = document.querySelector(".next"),
  todayBtn = document.querySelector(".today-btn"),
  gotoBtn = document.querySelector(".goto-btn"),
  dateInput = document.querySelector(".date-input"),
  eventDay = document.querySelector(".event-day"),
  eventDate = document.querySelector(".event-date"),
  eventsContainer = document.querySelector(".events"),
  addEventBtn = document.querySelector(".add-event"),
  addEventWrapper = document.querySelector(".add-event-wrapper "),
  addEventCloseBtn = document.querySelector(".close "),
  addEventTitle = document.querySelector(".event-name "),
  addEventFrom = document.querySelector(".event-time-from "),
  addEventTo = document.querySelector(".event-time-to "),

  addEventSubmit = document.querySelector(".add-event-btn ");
  
let today = new Date();
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


function getEvent(callback){
  var formData1 = new FormData();

  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function() {
      if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
        // Call the callback function with the parsed JSON response
        callback(JSON.parse(this.responseText));
      }
  };
  xhr.open("POST", "http://localhost:3000/selectAllEvent.php", true);
  xhr.send(formData1);
}




getEvent(function(eventsArr) {
 

  // /function to add days in days with class day and prev-date next-date on previous month and next month days and active on today
  function initCalendar() {
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const prevLastDay = new Date(year, month, 0);
    const prevDays = prevLastDay.getDate();
    const lastDate = lastDay.getDate();
    const day = firstDay.getDay();
    const nextDays = 7 - lastDay.getDay() - 1;
  
    date.innerHTML = months[month] + " " + year;
  
    let days = "";
  
    for (let x = day; x > 0; x--) {
      days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
    }
  
    for (let i = 1; i <= lastDate; i++) {
      //check if event is present on that day
      let event = false;
      eventsArr.forEach((eventObj) => {
        if (
          eventObj == i + " " + months[month] + " " + year
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
    daysContainer.innerHTML = days;
    addListner();
  }
  
  //function to add month and year on prev and next button
  function prevMonth() {
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
  
  prev.addEventListener("click", prevMonth);
  next.addEventListener("click", nextMonth);
  
  initCalendar();
  
  //function to add active on day
  function addListner() {
    const days = document.querySelectorAll(".day");
    days.forEach((day) => {
      day.addEventListener("click", (e) => {
        getActiveDay(e.target.innerHTML);
        updateEvents(Number(e.target.innerHTML));
        activeDay = Number(e.target.innerHTML);
        //remove active
        days.forEach((day) => {
          day.classList.remove("active");
        });
        //if clicked prev-date or next-date switch to that month
        if (e.target.classList.contains("prev-date")) {
          prevMonth();
          //add active to clicked day afte month is change
          setTimeout(() => {
            //add active where no prev-date or next-date
            const days = document.querySelectorAll(".day");
            days.forEach((day) => {
              if (
                !day.classList.contains("prev-date") &&
                day.innerHTML === e.target.innerHTML
              ) {
                day.classList.add("active");
              }
            });
          }, 100);
        } else if (e.target.classList.contains("next-date")) {
          nextMonth();
          //add active to clicked day afte month is changed
          setTimeout(() => {
            const days = document.querySelectorAll(".day");
            days.forEach((day) => {
              if (
                !day.classList.contains("next-date") &&
                day.innerHTML === e.target.innerHTML
              ) {
                day.classList.add("active");
              }
            });
          }, 100);
        } else {
          e.target.classList.add("active");
        }
      });
    });
  }
  
  todayBtn.addEventListener("click", () => {
    today = new Date();
    month = today.getMonth();
    year = today.getFullYear();
    initCalendar();
  });
  
  dateInput.addEventListener("input", (e) => {
    dateInput.value = dateInput.value.replace(/[^0-9/]/g, "");
    if (dateInput.value.length === 2) {
      dateInput.value += "/";
    }
    if (dateInput.value.length > 7) {
      dateInput.value = dateInput.value.slice(0, 7);
    }
    if (e.inputType === "deleteContentBackward") {
      if (dateInput.value.length === 3) {
        dateInput.value = dateInput.value.slice(0, 2);
      }
    }
  });
  
  gotoBtn.addEventListener("click", gotoDate);
  
  function gotoDate() {
    const dateArr = dateInput.value.split("/");
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
  
  //function get active day day name and date and update eventday eventdate
  function getActiveDay(date) {

    const day = new Date(year, month, date);
    const dayName = day.toString().split(" ")[0];
    eventDay.innerHTML = dayName;
    eventDate.innerHTML = date + " " + months[month] + " " + year;

    if (year < today.getFullYear() || 
        (year === today.getFullYear() && month < today.getMonth()) || 
        (year === today.getFullYear() && month === today.getMonth() && date < today.getDate())) {
      addEventBtn.disabled = true;
    } else {
      addEventBtn.disabled = false;
    }

  }
  
  //function update events when a day is active
  function updateEvents(date) {
    var formData = new FormData();
      
    formData.append("eventDate", date) 
  
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
          eventsContainer.innerHTML = this.responseText;
          const activeDayEl = document.querySelector(".day.active");
            if (!activeDayEl.classList.contains("event")) {
                activeDayEl.classList.add("event");
            }
            
            if (eventsContainer.innerHTML === '<div class="no-event"><h3>No Events</h3></div>') {
              activeDayEl.classList.remove("event");
            }
  
        }
    };
  
    xhr.open("POST", "http://localhost:3000/event.php", true);
    xhr.send(formData);
  
    
  }
  
  //function to add event
  addEventBtn.addEventListener("click", () => {
    addEventWrapper.classList.toggle("active");
  });
  
  addEventCloseBtn.addEventListener("click", () => {
    addEventWrapper.classList.remove("active");
  });
  
  document.addEventListener("click", (e) => {
    if (e.target !== addEventBtn && !addEventWrapper.contains(e.target)) {
      addEventWrapper.classList.remove("active");
    }
  });
  
  //allow 50 chars in eventtitle
  addEventTitle.addEventListener("input", (e) => {
    addEventTitle.value = addEventTitle.value.slice(0, 60);
  });
  


  
  //allow only time in eventtime from and to
  addEventFrom.addEventListener("input", (e) => {
    addEventFrom.value = addEventFrom.value.replace(/[^0-9:]/g, "");
    if (addEventFrom.value.length === 2) {
      addEventFrom.value += ":";
    }
    if (addEventFrom.value.length > 5) {
      addEventFrom.value = addEventFrom.value.slice(0, 5);
    }

  });
  
  addEventTo.addEventListener("input", (e) => {
    addEventTo.value = addEventTo.value.replace(/[^0-9:]/g, "");
    if (addEventTo.value.length === 2) {
      addEventTo.value += ":";
    }
    if (addEventTo.value.length > 5) {
      addEventTo.value = addEventTo.value.slice(0, 5);
    }
  });
  
  
  //function to delete event when clicked on event
  eventsContainer.addEventListener("click", (e) => {
    if (e.target.classList.contains("event")) {
      if (confirm("Are you sure you want to delete this event?")) {
      
        var formData = new FormData();
      
        formData.append("eventDate", eventDate.innerHTML)
        formData.append("eventName",e.target.children[0].children[1].innerHTML)
  
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                updateEvents(activeDay);
            }
        };
      
  
        xhr.open("POST", "http://localhost:3000/deleteEvent.php", true);
        xhr.send(formData);
      }
    }
  });
  
  
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
  
  
  
  // Prevent form submission and handle it with JavaScript
  document.getElementById("formAddEvent").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission
    const eventTitle = addEventTitle.value;
    const eventTimeFrom = addEventFrom.value;
    const eventTimeTo = addEventTo.value;
    if (eventTitle === "" || eventTimeFrom === "" || eventTimeTo === "") {
      alert("Please fill all the fields");
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

    const startHour = parseInt(timeFromArr[0], 10);
    const startMinute = parseInt(timeFromArr[1], 10);
    const endHour = parseInt(timeToArr[0], 10);
    const endMinute = parseInt(timeToArr[1], 10);
    
    // Check if start time is after end time
    if (startHour > endHour || (startHour === endHour && startMinute >= endMinute)) {
      alert("The event start time must be earlier than the end time.");
      return;
    }

    const now = new Date(); 
    const currentHour = now.getHours(); 
    const currentMinute = now.getMinutes(); 


    if ((startHour <  currentHour || (startHour == currentHour && currentMinute >= startMinute)) && now.getDate() + " " + months[now.getMonth()]+ " " + now.getFullYear() == eventDate.innerHTML) {
      alert("The event start time must be earlier than the current time.");
      return;
    }

    
    function addEvent() {
        var formData = new FormData();
        // Get input values
        var eventName = document.querySelector(".event-name").value;
        var eventTimeFrom = document.querySelector(".event-time-from").value;
        var eventTimeTo = document.querySelector(".event-time-to").value;
        var eventDate = document.querySelector(".event-date").innerHTML;
  
        console.log(eventDate)
        formData.append("event", eventName);
        formData.append("eventstart", eventTimeFrom);
        formData.append("eventfinished", eventTimeTo);
        formData.append("getEventDate", eventDate);
  
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
              
              if(this.responseText == "exist event in this time"){
                alert("Exist event in this time.");
              }
              else if(this.responseText == "The event start time must be earlier than the end time."){
                alert("The event start time must be earlier than the end time.");
              }
              else if(this.responseText ==  "The event start time must be earlier than the current time."){
                alert("The event start time must be earlier than the current time.");
              }
              else{
                if (eventsContainer.innerHTML === '<div class="no-event"><h3>No Events</h3></div>') {
                  eventsContainer.innerHTML = this.responseText
              }
              else
                eventsContainer.innerHTML += this.responseText;
              
                addEventWrapper.classList.remove("active");
    
                const activeDayEl = document.querySelector(".day.active");
                if (!activeDayEl.classList.contains("event")) {
                    activeDayEl.classList.add("event");
                }  
                        
         
              }
                
            }
        };
  
        xhr.open("POST", "http://localhost:3000/saveEvent.php", true);
        xhr.send(formData);
    }
  
    addEvent();
  });
  
  
  

  
});








