CREATE TABLE `facilities` (
  `facilityid` int(11) NOT NULL AUTO_INCREMENT,
  `facilityname` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `price` double NOT NULL,
  `configuration` varchar(255) NOT NULL,
  `username` varchar(255),
  PRIMARY KEY(`facilityid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

create table users
(
  userID serial primary key,
  username varchar(30),
  password char(40),
  reg_date datetime
);
