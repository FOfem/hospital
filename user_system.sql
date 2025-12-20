CREATE DATABASE user_system;
USE user_system;

CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    other_name VARCHAR(50),
    address TEXT NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    phone_number VARCHAR(20) NOT NULL UNIQUE,
    guidance TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
