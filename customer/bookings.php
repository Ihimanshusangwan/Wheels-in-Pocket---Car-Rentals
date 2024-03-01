<?php
session_start();
require_once "../config.php"; 

// Check if customer ID is set in session
if (!isset($_SESSION['customer_id'])) {
    // Redirect to login page or display error message
    header("Location: login.php");
    exit; // Stop further execution
}

// Fetch bookings for the logged-in customer along with agency details
$customer_id = $_SESSION['customer_id'];
$stmt = $conn->prepare("SELECT bookings.booking_id, cars.vehicle_model, cars.vehicle_number, bookings.start_date, bookings.booking_date, bookings.end_date, agencies.name AS agency_name, agencies.address AS agency_address, agencies.mobile AS agency_mobile
                        FROM bookings
                        INNER JOIN cars ON bookings.car_id = cars.car_id
                        INNER JOIN agencies ON cars.agency_id = agencies.agency_id
                        WHERE bookings.customer_id = ? order by bookings.booking_id desc");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Bookings</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Wheels in Pocket</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="../index.php" >
                        Home
                        </a>
                    </li>
                
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
    // Check if there are any bookings
if ($result->num_rows > 0) {
    ?>
    <div class="container mt-5">
        <h2 class="mb-4">Your Bookings</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Booking Date and Time</th>
                    <th>Vehicle Model</th>
                    <th>Vehicle Number</th>
                    <th>Agency Name</th>
                    <th>Agency Address</th>
                    <th>Agency Mobile</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$count}</td>";
                    echo "<td>{$row['booking_date']}</td>";
                    echo "<td>{$row['vehicle_model']}</td>";
                    echo "<td>{$row['vehicle_number']}</td>";
                    echo "<td>{$row['agency_name']}</td>";
                    echo "<td>{$row['agency_address']}</td>";
                    echo "<td>{$row['agency_mobile']}</td>";
                    echo "<td>{$row['start_date']}</td>";
                    echo "<td>{$row['end_date']}</td>";
                    echo "</tr>";
                    $count++;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
} else {
    // No bookings found for the customer
    echo "No bookings found.";
}
?>
