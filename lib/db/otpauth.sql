-- MySQL dump 10.13 
--
-- Host: localhost    Database: 
-- ------------------------------------------------------
--
-- Current Database: `otpauth`
--

/*!40000 DROP DATABASE IF EXISTS `otpauth`*/;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `otpauth` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `otpauth`;

--
-- Table structure for table `otp_users`
--

DROP TABLE IF EXISTS `otp_users`;
CREATE TABLE `otp_users` (
  `ID` int(4) NOT NULL AUTO_INCREMENT,
  `USER` varchar(30) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `SECRETKEY` varchar(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB;

--
-- Table structure for table `otp_logaccess`
--

DROP TABLE IF EXISTS `otp_logaccess`;
CREATE TABLE `otp_logaccess` (
  `ID` int(10) NOT NULL,
  `USER_ID` int(4) NOT NULL,
  `ACCESS` tinyint(1) NOT NULL,
  `ACCESS_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `USER_ID` (`USER_ID`),
  CONSTRAINT `otp_logaccess_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `otp_users` (`ID`)
) ENGINE=InnoDB;

--
-- Table structure for table `otp_recoverycodes`
--

DROP TABLE IF EXISTS `otp_recoverycodes`;
CREATE TABLE `otp_recoverycodes` (
  `ID` int(4) NOT NULL,
  `USER_ID` int(4) NOT NULL,
  `RECOVERYCODE` varchar(5) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `USER_ID` (`USER_ID`),
  CONSTRAINT `otp_recoverycodes_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `otp_users` (`ID`)
) ENGINE=InnoDB;


