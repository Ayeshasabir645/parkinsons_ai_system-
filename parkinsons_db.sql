CREATE DATABASE IF NOT EXISTS parkinsons_db;
USE parkinsons_db;

CREATE TABLE IF NOT EXISTS users (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    full_name   VARCHAR(100)  NOT NULL,
    email       VARCHAR(150)  UNIQUE NOT NULL,
    password    VARCHAR(255)  NOT NULL,
    role        ENUM('admin','doctor','researcher') DEFAULT 'doctor',
    hospital    VARCHAR(100),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS patients (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    patient_name    VARCHAR(100) NOT NULL,
    age             INT,
    gender          ENUM('Male','Female','Other'),
    tremor_level    INT CHECK(tremor_level BETWEEN 1 AND 10),
    diagnosis       ENUM('Positive','Negative','Pending') DEFAULT 'Pending',
    assigned_doctor VARCHAR(100),
    notes           TEXT,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (full_name, email, password, role, hospital)
VALUES ('Admin User', 'admin@parkinsons.com', MD5('admin123'), 'admin', 'City Hospital');

INSERT INTO patients (patient_name, age, gender, tremor_level, diagnosis, assigned_doctor, notes) VALUES
('Muhammad Ali',     65, 'Male',   7, 'Positive', 'Dr. Ahmed',  'Regular tremors observed'),
('Sara Khan',        58, 'Female', 4, 'Pending',  'Dr. Fatima', 'Follow-up required'),
('Imran Butt',       72, 'Male',   9, 'Positive', 'Dr. Ahmed',  'Severe case'),
('Ayesha Siddiqui',  61, 'Female', 2, 'Negative', 'Dr. Zara',   'Mild symptoms only'),
('Tariq Mehmood',    69, 'Male',   6, 'Positive', 'Dr. Ahmed',  'On medication');