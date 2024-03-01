CREATE TABLE Customers (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100)  NOT NULL,
    name VARCHAR(255) NOT NULL,
    mobile VARCHAR(15) NOT NULL
);

CREATE TABLE Agencies (
    agency_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    address VARCHAR(300) NOT NULL,
    mobile VARCHAR(15) NOT NULL, 
    name VARCHAR(255) NOT NULL

);

CREATE TABLE Cars (
    car_id INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_model VARCHAR(150) NOT NULL,
    body_type VARCHAR(50) NOT NULL,
    fuel VARCHAR(50) NOT NULL,
    transmission VARCHAR(50) NOT NULL,
    vehicle_number VARCHAR(25) UNIQUE NOT NULL,
    seating_capacity INT NOT NULL,
    rent_per_day DECIMAL(10,2) NOT NULL,
    agency_id INT,
    FOREIGN KEY (agency_id) REFERENCES Agencies(agency_id),
    images TEXT DEFAULT NULL
);

CREATE TABLE Bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT,
    customer_id INT,
    booking_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    FOREIGN KEY (car_id) REFERENCES Cars(car_id),
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id)
);
