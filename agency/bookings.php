<?php
session_start();
require_once "../config.php"; 

if (!isset($_SESSION['agency_id'])) {
    header("Location: login.php");
    exit; 
}

// Fetch bookings for the logged-in agency along with customer details
$agency_id = $_SESSION['agency_id'];
$stmt = $conn->prepare("SELECT Bookings.booking_id, Customers.name AS customer_name, Customers.email AS customer_email, Customers.mobile AS customer_mobile, Cars.vehicle_model, Cars.vehicle_number, Bookings.start_date, Bookings.booking_date, Bookings.end_date
                        FROM Bookings
                        INNER JOIN Cars ON Bookings.car_id = Cars.car_id
                        INNER JOIN Customers ON Bookings.customer_id = Customers.customer_id
                        WHERE Cars.agency_id = ?");
$stmt->bind_param("i", $agency_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Bookings</title>
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
        <h2 class="mb-4">Bookings</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Booking Date and Time</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Mobile</th>
                    <th>Vehicle Model</th>
                    <th>Vehicle Number</th>
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
                    echo "<td>{$row['customer_name']}</td>";
                    echo "<td>{$row['customer_email']}</td>";
                    echo "<td>{$row['customer_mobile']}</td>";
                    echo "<td>{$row['vehicle_model']}</td>";
                    echo "<td>{$row['vehicle_number']}</td>";
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
    // No bookings found for the agency
    echo "No bookings found.";
}
?>
