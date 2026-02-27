CREATE DATABASE campusone;
USE campusone;

CREATE TABLE admins (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        username VARCHAR(50) UNIQUE NOT NULL,
                        password VARCHAR(255) NOT NULL
);

CREATE TABLE students (
                          nic VARCHAR(20) PRIMARY KEY,
                          name VARCHAR(100) NOT NULL,
                          gender ENUM('Male', 'Female', 'Other') NOT NULL,
                          address TEXT NOT NULL,
                          contact VARCHAR(15) NOT NULL,
                          email VARCHAR(100) NOT NULL,
                          course VARCHAR(100) NOT NULL
);

/* use this code to create your data base using sql in phpmyadmin */