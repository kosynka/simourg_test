CREATE DATABASE simourg DEFAULT CHARACTER SET = 'utf8mb4';

CREATE TABLE simourg.processes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NULL
);

CREATE TABLE simourg.process_fields (
    id INT AUTO_INCREMENT PRIMARY KEY,
    process_id INT,
    name VARCHAR(255),
    type ENUM('text', 'number', 'date'),
    value TEXT,
    number_format VARCHAR(255),
    date_format VARCHAR(255),
    FOREIGN KEY (process_id) REFERENCES processes (id)
);
