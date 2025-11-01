CREATE DATABASE IF NOT EXISTS `ticketmaster`;
USE `ticketmaster`;

DROP TABLE IF EXISTS `accounts`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `eventDetails`;

CREATE TABLE IF NOT EXISTS `accounts` (
  `accID` INT AUTO_INCREMENT,
  `accEmail` VARCHAR(20) NOT NULL,
  `accPassword` VARCHAR(100) NOT NULL,
  `accBookings` VARCHAR(100) NOT NULL,
  `accAdmin` BOOLEAN NOT NULL,
  PRIMARY KEY (`accID`)
);

CREATE TABLE IF NOT EXISTS `events` (
  `id` INT AUTO_INCREMENT,
  `eventName` VARCHAR(100) NOT NULL,
  `eventLocation` VARCHAR(100) NOT NULL,
  `eventDate` VARCHAR(100) NOT NULL,
  `eventTime` VARCHAR(100) NOT NULL,
  `eventTicketMaxAMT` VARCHAR(100) NOT NULL,
  `eventTicketMinAMT` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `eventDetails` (
  `id` INT AUTO_INCREMENT,
  `accIDS` VARCHAR(100) NOT NULL,
  `eventLocation` VARCHAR(100) NOT NULL,
  `eventDate` VARCHAR(100) NOT NULL,
  `eventTime` VARCHAR(100) NOT NULL,
  `eventTicketAMT` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
);

select * from accounts;
select * from events;