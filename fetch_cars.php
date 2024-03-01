<?php
include_once "config.php";

// Fetching cars based on offset
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0; 
$limit = 3; // number of cars to fetch at a time

// Prepare and execute SQL query to fetch cars with limit, offset
$stmt = $conn->prepare("SELECT c.*, a.name as agency_name FROM Cars c 
                       INNER JOIN Agencies a ON c.agency_id = a.agency_id
                       ORDER BY c.car_id DESC 
                       LIMIT ?, ?");
$stmt->bind_param("ii", $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();
$cars = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

//  fetched cars as JSON and sending response
header('Content-Type: application/json');
echo json_encode($cars);
