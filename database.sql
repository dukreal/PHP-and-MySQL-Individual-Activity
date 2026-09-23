
CREATE DATABASE IF NOT EXISTS contact_list_db;
USE contact_list_db;

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    last_name VARCHAR(50) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    contact_number VARCHAR(15) NOT NULL
);
