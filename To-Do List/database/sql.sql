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
-- setting time zone for America/Chicago
SET time_zone = "-06:00";


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

-- Test user as sample record in user table
INSERT INTO users (fullname, email, password) VALUES ('test user', 'test@mail.com', 'db979ece7eb525a2a2df069d7b04ff661bbd0d285d9526c15626e12997e3c650934181fa7fcb54616d62f1293ec1624f6f1205f3e80aa8fc4379333b024dd86e');


-- Table structure for table todos
CREATE TABLE todos (
  todo_id int(10) NOT NULL AUTO_INCREMENT,
  title varchar(150) NOT NULL,
  description text,
  priority varchar(10) DEFAULT 'Medium',
  category varchar(10) DEFAULT 'Personal',
  status varchar(15) NOT NULL DEFAULT 'Not Started',
  created_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  modified_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  due_date datetime NOT NULL,
  user_id int(10) NOT NULL,
  PRIMARY KEY (todo_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- test user todo's as sample records in todos table
INSERT INTO todos (title, description, priority, category, status, due_date, user_id) VALUES
('Advance Web Application Project Source Code Submission', 'Submission Details,\r\n- Each team member should submit the files on the Blackboard.\r\n- Include All files needed to run your application in ONE ZIP file.\r\n- The application should work on professor side WITHOUT additional configuration or setting except SQL server configuration (The laptop I use for grading has only MAMP and VSC installed).\r\n   : database id & passwd for PDO: php, phpdb\r\n- Before your submit, TEST your application at completely different computer.\r\n- Check out folder alias', 'High', 'Work', 'Completed', '2022-11-30 23:59:59', '1'), 
('Create PPT for Adv Web Applications Project', 'Create PPT and submit it by 10.00 AM on the presentation day !!\r\nBatch No:06', 'Medium', 'Work', 'In Progress', '2022-12-08 09:59:59', '1'),
('Get Feedback', 'After presentation, get feedback from professor about project', 'Low', 'Personal', 'Not Started', '2022-12-09 00:00:00', '1');