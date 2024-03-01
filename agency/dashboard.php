<?php
session_start();
if (!isset($_SESSION["username"]) && isset($_SESSION["agency_id"])) {
    header("location: ../signin.php?tab=agency");
} else {
    $agency_id = $_SESSION["agency_id"];
}
require_once "../config.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Dashboard - Wheels in Pocket</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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
                        <a class="nav-link" href="bookings.php" >
                            <i class="fas fa-car"></i> Bookings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#addCarModal">
                            <i class="fas fa-plus"></i> Add Car
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

    <!-- Add Car Modal -->
    <div class="modal fade" id="addCarModal" tabindex="-1" role="dialog" aria-labelledby="addCarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCarModalLabel">Add New Car</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display errors if any -->
                    <?php
                    // Check if there are errors in session
                    if (isset($_SESSION['errors'])) {
                        $errors = $_SESSION['errors'];
                        // Unset errors from session to clear them
                        unset($_SESSION['errors']);
                    }
                    if (isset($errors) && !empty($errors)): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li>
                                        <?php echo $error; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <!--  form to add new car here -->
                    <?php include_once("add_car_form.php"); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="row">
            <?php
            $query = "SELECT * FROM cars WHERE agency_id = ? order by car_id desc";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $agency_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if there are any cars listed
            if ($result->num_rows > 0) {
                // Display each car 
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="row no-gutters">
                                <div class="card-body">

                                    <?php if (!empty($row['images'])): ?>
                                        <img src="<?php echo '../'.$row['images']; ?>" class="card-img"
                                            alt="<?php echo $row['vehicle_model']; ?>">
                                    <?php else: ?>
                                        <img src="../default_car_image.jpg" class="card-img" alt="Default Car Image">
                                    <?php endif; ?>


                                    <h5 class="card-title text-primary text-center">
                                        <?php echo $row['vehicle_model']; ?>
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="card-text mb-0"><i class="fas fa-car text-success"></i>
                                                <span class="text-small">
                                                    <?php echo $row['body_type']; ?>
                                                </span>
                                            </p>
                                            <p class="card-text mb-0"><i class="fas fa-gas-pump text-danger"></i>
                                                <span class="text-small">
                                                    <?php echo $row['fuel']; ?>
                                                </span>
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <p class="card-text mb-0"><i class="fas fa-cogs text-warning"></i>
                                                <span class="text-small">
                                                    <?php echo $row['transmission']; ?>
                                                </span>
                                            </p>
                                            <p class="card-text mb-0"><i class="fas fa-chair text-info"></i>
                                                <span class="text-small">
                                                    <?php echo $row['seating_capacity']; ?> Seats
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <h5 class="card-title text-secondary mt-1">
                                        <i class="fas fa-rupee-sign text-muted"></i>
                                        <?php echo $row['rent_per_day']; ?>
                                        <span style="color: black; font-size: 14px;">/day</span>
                                    </h5>
                                    <!-- Edit Button -->
                                    <a href="edit_car.php?car_id=<?php echo $row['car_id']; ?>"
                                        class="btn btn-primary btn-sm btn-block">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>


                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                }
            } else {
                // Display message if no cars are listed
                echo "<div class='col-12'><p>No cars listed by the agency.</p></div>";
            }

            // Close the statement and result set
            $stmt->close();
            $result->close();
            ?>
        </div>
    </div>

    <!-- Footer Section -->
    <?php include_once("../footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Check if URL parameter form=visible
            const urlParams = new URLSearchParams(window.location.search);
            const formVisible = urlParams.get('form');
            if (formVisible === 'visible') {
                $('#addCarModal').modal('show'); // Show the modal
            }
        });
    </script>
</body>

</html>