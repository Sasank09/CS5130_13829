CREATE DATABASE sitename;

USE sitename;

CREATE TABLE users (
user_id MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
first_name VARCHAR(20) NOT NULL,
last_name VARCHAR(40) NOT NULL,
email VARCHAR(60) NOT NULL,
pass CHAR(128) NOT NULL,
registration_date DATETIME NOT NULL,
PRIMARY KEY (user_id)
);

INSERT INTO users
(first_name, last_name, email, pass, registration_date)
VALUES ('Larry', 'Ullman', 'email@example.com', SHA2('mypass', 512), NOW());

INSERT INTO users VALUES
(NULL, 'Zoe', 'Isabella', 'email2@example.com', SHA2('mojito', 512), NOW());

INSERT INTO users (first_name, last_name, email, pass, registration_date) VALUES
('John', 'Lennon', 'john@beatles.com', SHA2('Happin3ss', 512), NOW()),
('Paul', 'McCartney', 'paul@beatles.com', SHA2('letITbe', 512), NOW()),
('George', 'Harrison', 'george@beatles.com ', SHA2('something', 512), NOW()),
('Ringo', 'Starr', 'ringo@beatles.com', SHA2('thisboy', 512), NOW());