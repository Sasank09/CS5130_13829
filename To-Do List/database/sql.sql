-- phpMyAdmin SQL Dump

-- Database Server: localhost via TCP/IP
-- Server type: MySQL
-- Server version: 5.7.24 - MySQL Community Server (GPL)
-- User: root@localhost
-- Server charset: UTF-8 Unicode (utf8)

-- Web Server - localhost 
-- Apache/2.4.33 (Win64) OpenSSL/1.0.2u mod_fcgid/2.3.9 PHP/8.0.1
-- PHP version: 8.0.1


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- Database todo_list
CREATE DATABASE IF NOT EXISTS todo_list;
USE todo_list;

-- Table structure for table `users`

CREATE TABLE users (
  user_id int(10) NOT NULL AUTO_INCREMENT,
  fullname varchar(255) NOT NULL,
  email varchar(255) NOT NULL UNIQUE,
  password varchar(255) NOT NULL,
  created_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table todos

CREATE TABLE todos (
  todo_id int(10) NOT NULL AUTO_INCREMENT,
  title varchar(75) NOT NULL,
  description text,
  priority varchar(10) DEFAULT 'Medium',
  category varchar(10) DEFAULT 'Personal',
  status varchar(15) NOT NULL DEFAULT 'Not Started',
  created_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  due_date datetime,
  user_id int(10) NOT NULL,
  PRIMARY KEY (todo_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

