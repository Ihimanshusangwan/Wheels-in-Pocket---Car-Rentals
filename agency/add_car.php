<?php
session_start();

include_once "../config.php";
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate vehicle model
    if (empty($_POST['vehicle_model'])) {
        $errors['vehicle_model'] = "Vehicle model is required";
    } else {
        $vehicle_model = cleanInput($_POST['vehicle_model']);
    }

    // Validate body type
    if (empty($_POST['body_type'])) {
        $errors['body_type'] = "Body type is required";
    } else {
        $body_type = cleanInput($_POST['body_type']);
    }

    // Validate fuel type
    if (empty($_POST['fuel'])) {
        $errors['fuel'] = "Fuel type is required";
    } else {
        $fuel = cleanInput($_POST['fuel']);
    }

    // Validate transmission type
    if (empty($_POST['transmission'])) {
        $errors['transmission'] = "Transmission type is required";
    } else {
        $transmission = cleanInput($_POST['transmission']);
    }

    // Validate vehicle number
    if (empty($_POST['vehicle_number'])) {
        $errors['vehicle_number'] = "Vehicle number is required";
    } else {
        $vehicle_number = cleanInput($_POST['vehicle_number']);

        // Check if the vehicle number already exists
        $stmt = $conn->prepare("SELECT car_id FROM cars WHERE vehicle_number = ?");
        $stmt->bind_param("s", $vehicle_number);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $errors['vehicle_number'] = "This vehicle number is already registered.";
        }

        $stmt->close();
    }

    // Validate seating capacity
    if (empty($_POST['seating_capacity'])) {
        $errors['seating_capacity'] = "Seating capacity is required";
    } else {
        $seating_capacity = cleanInput($_POST['seating_capacity']);
    }

    // Validate rent per day
    if (empty($_POST['rent_per_day'])) {
        $errors['rent_per_day'] = "Rent per day is required";
    } else {
        $rent_per_day = cleanInput($_POST['rent_per_day']);
    }

    $agency_id = $_SESSION['agency_id'];

    // Validate image upload
    if ($_FILES['image']['error'] === 0) {
        // Generate unique image name
        $image = generateUniqueImageName($_FILES['image']);
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image = "uploads/" . $image;
    } else {
        $errors[] = "Error occurred during file upload.";
    }


    // If there are errors, store them in session and redirect back 
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: dashboard.php?form=visible");
        exit();
    }

    // If no errors, insert into database
    $stmt = $conn->prepare("INSERT INTO cars (vehicle_model, body_type, fuel, transmission, vehicle_number, seating_capacity, rent_per_day, agency_id, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssisss", $vehicle_model, $body_type, $fuel, $transmission, $vehicle_number, $seating_capacity, $rent_per_day, $agency_id, $image);

    $stmt->execute();

    $stmt->close();
    $conn->close();

    // Redirect to success page or do any other action after successful insertion
    header("Location: dashboard.php");
    exit();
}

// Function to clean input data
function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to generate unique image name
function generateUniqueImageName($file)
{
    $timestamp = time();
    $filename = $timestamp . '_' . basename($file["name"]);
    return $filename;
}

