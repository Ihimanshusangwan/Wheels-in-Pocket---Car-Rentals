<?php
session_start();
require_once "../config.php"; 

// Function to sanitize input data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $car_id = isset($_POST['car_id']) ? intval(sanitizeInput($_POST['car_id'])) : null;
    $start_date = isset($_POST['start_date']) ? sanitizeInput($_POST['start_date']) : null;
    $number_of_days = isset($_POST['number_of_days']) ? intval(sanitizeInput($_POST['number_of_days'])) : null;

    // Validate start date format
    if (!empty($start_date) && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $start_date)) {
        die("Invalid start date format.");
    }

    // Validate number of days
    if ($number_of_days <= 0 || $number_of_days > 10) {
        die("Number of days should be between 1 and 10.");
    }

    // Get customer_id from session
    $customer_id = isset($_SESSION['customer_id']) ? intval($_SESSION['customer_id']) : null;

    if ($customer_id === null) {
        die("Error: Customer ID not found in session.");
    }

    // Calculate end date based on start date and number of days
    $end_date = date('Y-m-d', strtotime($start_date . ' + ' . $number_of_days . ' days'));

    // Insert booking into database
    $stmt = $conn->prepare("INSERT INTO bookings (car_id, customer_id, start_date, end_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $car_id, $customer_id, $start_date, $end_date);
    
    if ($stmt->execute()) {
        header("location: booking_success.html");
    } else {
        die( "Error occurred while saving booking.");
    }
}
