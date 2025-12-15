CREATE DATABASE harrypotter;
USE harrypotter;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    fullname VARCHAR(100),
    username VARCHAR(50),
    password VARCHAR(255),
    role ENUM('student','teacher') DEFAULT 'student',
    score INT DEFAULT 0
);