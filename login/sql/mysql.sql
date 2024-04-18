CREATE DATABASE EventCalendar;
USE EventCalendar;

CREATE TABLE Users (
    Userid INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pwd VARCHAR(100) NOT NULL
);

CREATE TABLE Events (
    id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Eventname VARCHAR(50) NOT NULL,
    timestart TIME,
    timefinish TIME,
    Eventday DATETIME,
    Userid INT(5) UNSIGNED,
    FOREIGN KEY (Userid) REFERENCES Users(Userid)
);
