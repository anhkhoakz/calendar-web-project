CREATE TABLE `calendar_event_master` (
    `event_id` int(11) NOT NULL AUTO_INCREMENT,
    `event_name` varchar(255) DEFAULT NULL,
    `event_start_date` date DEFAULT NULL,
    `event_end_date` date DEFAULT NULL,
    PRIMARY KEY (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;