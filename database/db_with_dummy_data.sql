-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2024 at 03:05 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `agencies`
--

CREATE TABLE `agencies` (
  `agency_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(300) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agencies`
--

INSERT INTO `agencies` (`agency_id`, `username`, `password`, `email`, `address`, `mobile`, `name`) VALUES
(1, 'agency1', 'password1', 'agency1@example.com', '123 Agency Street, City', '9876543211', 'Agency One'),
(2, 'agency2', 'password2', 'agency2@example.com', '456 Agency Avenue, Town', '9876543212', 'Agency Two'),
(3, 'agency3', 'password3', 'agency3@example.com', '789 Agency Road, Village', '9876543213', 'Agency Three'),
(4, 'agency4', 'password4', 'agency4@example.com', '321 Agency Lane, County', '9876543214', 'Agency Four'),
(5, 'agency5', 'password5', 'agency5@example.com', '654 Agency Court, State', '9876543215', 'Agency Five'),
(6, 'agency6', 'password6', 'agency6@example.com', '987 Agency Circle, Country', '9876543216', 'Agency Six'),
(7, 'agency7', 'password7', 'agency7@example.com', '101 Agency Boulevard, Metropolis', '9876543217', 'Agency Seven'),
(8, 'agency8', 'password8', 'agency8@example.com', '210 Agency Square, Capital', '9876543218', 'Agency Eight'),
(9, 'agency9', 'password9', 'agency9@example.com', '543 Agency Plaza, Megalopolis', '9876543219', 'Agency Nine'),
(10, 'agency10', 'password10', 'agency10@example.com', '876 Agency Park, Cityscape', '9876543210', 'Agency Ten'),
(11, 'Agency new', '$2y$10$bUHP06kwHl9NaFsptpVbjesGDaBygs7QM1JnFBaClmR00wcGrKZ0W', 'ajk@gmail.com', 'ajksldfjdskf ,as fkasdf', '1234567890', 'Test Agency');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `vehicle_model` varchar(150) NOT NULL,
  `body_type` varchar(50) NOT NULL,
  `fuel` varchar(50) NOT NULL,
  `transmission` varchar(50) NOT NULL,
  `vehicle_number` varchar(25) NOT NULL,
  `seating_capacity` int(11) NOT NULL,
  `rent_per_day` decimal(10,2) NOT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `images` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `vehicle_model`, `body_type`, `fuel`, `transmission`, `vehicle_number`, `seating_capacity`, `rent_per_day`, `agency_id`, `images`) VALUES
(1, 'Toyota Corolla', 'Sedan', 'Petrol', 'Automatic', 'ABC001', 5, 50.00, 1, ''),
(2, 'Honda Civic', 'Sedan', 'Petrol', 'Manual', 'ABC002', 5, 55.00, 2, ''),
(3, 'Ford Mustang', 'Sedan', 'Petrol', 'Automatic', 'ABC003', 4, 70.00, 3, ''),
(4, 'Toyota RAV4', 'SUV', 'Petrol', 'Automatic', 'ABC004', 5, 65.00, 4, ''),
(5, 'Nissan Rogue', 'SUV', 'Petrol', 'Automatic', 'ABC005', 5, 60.00, 5, ''),
(6, 'Subaru Outback', 'SUV', 'Diesel', 'Manual', 'ABC006', 5, 55.00, 6, ''),
(7, 'Volkswagen Golf', 'Hatchback', 'Petrol', 'Manual', 'ABC007', 5, 45.00, 7, ''),
(8, 'Hyundai Elantra', 'Sedan', 'Petrol', 'Automatic', 'ABC008', 5, 50.00, 8, ''),
(9, 'Kia Soul', 'Hatchback', 'Petrol', 'Manual', 'ABC009', 5, 40.00, 9, ''),
(10, 'Mazda CX-5', 'SUV', 'Petrol', 'Automatic', 'ABC010', 5, 70.00, 10, ''),
(11, 'Toyota Camry', 'Sedan', 'Petrol', 'Automatic', 'ABC011', 5, 60.00, 1, ''),
(12, 'Honda CR-V', 'SUV', 'Petrol', 'Automatic', 'ABC012', 5, 65.00, 2, ''),
(13, 'Ford Explorer', 'SUV', 'Diesel', 'Automatic', 'ABC013', 7, 80.00, 3, ''),
(14, 'Chevrolet Equinox', 'SUV', 'Petrol', 'Automatic', 'ABC014', 5, 55.00, 4, ''),
(15, 'Nissan Sentra', 'Sedan', 'Petrol', 'Manual', 'ABC015', 5, 45.00, 5, ''),
(16, 'Subaru Impreza', 'Hatchback', 'Petrol', 'Manual', 'ABC016', 5, 40.00, 6, ''),
(17, 'Volkswagen Tiguan', 'SUV', 'Diesel', 'Automatic', 'ABC017', 5, 70.00, 7, ''),
(18, 'Hyundai Sonata', 'Sedan', 'Petrol', 'Automatic', 'ABC018', 5, 55.00, 8, ''),
(19, 'Kia Sportage', 'SUV', 'Petrol', 'Automatic', 'ABC019', 5, 60.00, 9, ''),
(20, 'Mazda3', 'Hatchback', 'Petrol', 'Manual', 'ABC020', 5, 45.00, 10, ''),
(21, 'Toyota Highlander', 'SUV', 'Petrol', 'Automatic', 'ABC021', 7, 75.00, 1, ''),
(22, 'Honda Accord', 'Sedan', 'Petrol', 'Automatic', 'ABC022', 5, 55.00, 2, ''),
(23, 'Ford Escape', 'SUV', 'Diesel', 'Automatic', 'ABC023', 5, 60.00, 3, ''),
(24, 'Chevrolet Malibu', 'Sedan', 'Petrol', 'Automatic', 'ABC024', 5, 50.00, 4, ''),
(25, 'Nissan Kicks', 'SUV', 'Petrol', 'Automatic', 'ABC025', 5, 65.00, 5, ''),
(26, 'Subaru Crosstrek', 'SUV', 'Petrol', 'Automatic', 'ABC026', 5, 60.00, 6, ''),
(27, 'Volkswagen Jetta', 'Sedan', 'Petrol', 'Manual', 'ABC027', 5, 45.00, 7, ''),
(28, 'Hyundai Santa Fe', 'SUV', 'Diesel', 'Automatic', 'ABC028', 7, 80.00, 8, ''),
(29, 'Kia Seltos', 'SUV', 'Petrol', 'Automatic', 'ABC029', 5, 55.00, 9, ''),
(30, 'Mazda CX-9', 'SUV', 'Petrol', 'Automatic', 'ABC030', 7, 85.00, 10, '');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agencies`
--
ALTER TABLE `agencies`
  ADD PRIMARY KEY (`agency_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD UNIQUE KEY `vehicle_number` (`vehicle_number`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agencies`
--
ALTER TABLE `agencies`
  MODIFY `agency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`agency_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
