<?php
session_start();
if (!isset($_SESSION["username"]) && isset($_SESSION["agency_id"])) {
    header("location: ../signin.php?tab=agency");
} else {
    $car_id = $_GET["car_id"];
}
require_once "../config.php";

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

    // If there are errors, store them in session and redirect back 
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: edit_car.php?car_id=" . $_POST['car_id']);
        exit();
    }


   // Check if the image file has been uploaded
if ($_FILES['image']['error'] === 0) {
    // Generate unique image name
    $image = generateUniqueImageName($_FILES['image']);
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $image = "uploads/" . $image;
    
    // Delete existing image if it exists
    if (!empty($_POST['existing_image'])) {
        $existing_image_path = "../" . cleanInput($_POST['existing_image']);
        if (file_exists($existing_image_path)) {
            unlink($existing_image_path);
        }
    }
} else {
    // If no new image uploaded, retain the existing image path
    $image = cleanInput($_POST['existing_image']);
}

    // Update the record in the database
    $stmt = $conn->prepare("UPDATE cars SET vehicle_model = ?, body_type = ?, fuel = ?, transmission = ?, vehicle_number = ?, seating_capacity = ?, rent_per_day = ?, images = ? WHERE car_id = ?");
    $stmt->bind_param("sssssisss", $vehicle_model, $body_type, $fuel, $transmission, $vehicle_number, $seating_capacity, $rent_per_day, $image, $_POST['car_id']);
    $stmt->execute();
    $stmt->close();

    // Redirect to success page 
    header("Location: car_update_success.html");
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car - Wheels in Pocket</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Wheels in Pocket</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="navbar-text">
                            <?php
                            // Display welcome message with username
                            if (isset($_SESSION["username"]) && isset($_SESSION["agency_id"])) {
                                echo 'Welcome, ' . $_SESSION["username"];
                            }
                            ?>
                        </span>
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
    $query = "SELECT * FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if car_id is valid or not
    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
        ?>
        <h2 class="text-center">Edit Car Information:</h2><br />
        <div class="container col-md-8 my-3">
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="car_id" value="<?php echo $_GET['car_id']; ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="vehicle_model">Vehicle Model</label>
                        <input type="text" name="vehicle_model" id="vehicle_model" class="form-control" required
                            value="<?php echo $car['vehicle_model']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="body_type">Body Type</label>
                        <select name="body_type" id="body_type" class="form-control" required>
                            <option value="">Select Body Type</option>
                            <option value="Sedan" <?php if ($car['body_type'] == 'Sedan')
                                echo 'selected'; ?>>Sedan</option>
                            <option value="SUV" <?php if ($car['body_type'] == 'SUV')
                                echo 'selected'; ?>>SUV</option>
                            <option value="Hatchback" <?php if ($car['body_type'] == 'Hatchback')
                                echo 'selected'; ?>>Hatchback
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Second row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fuel">Fuel Type</label>
                        <select name="fuel" id="fuel" class="form-control" required>
                            <option value="">Select Fuel Type</option>
                            <option value="Petrol" <?php if ($car['fuel'] == 'Petrol')
                                echo 'selected'; ?>>Petrol</option>
                            <option value="Diesel" <?php if ($car['fuel'] == 'Diesel')
                                echo 'selected'; ?>>Diesel</option>
                            <option value="Electric" <?php if ($car['fuel'] == 'Electric')
                                echo 'selected'; ?>>Electric
                            </option>
                            <option value="Cng" <?php if ($car['fuel'] == 'Cng')
                                echo 'selected'; ?>>CNG</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="transmission">Transmission</label>
                        <select name="transmission" id="transmission" class="form-control" required>
                            <option value="">Select Transmission Type</option>
                            <option value="Manual" <?php if ($car['transmission'] == 'Manual')
                                echo 'selected'; ?>>Manual
                            </option>
                            <option value="Automatic" <?php if ($car['transmission'] == 'Automatic')
                                echo 'selected'; ?>>
                                Automatic</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Third row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="vehicle_number">Vehicle Number</label>
                        <input type="text" name="vehicle_number" id="vehicle_number" class="form-control" required
                            value="<?php echo $car['vehicle_number']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="seating_capacity">Seating Capacity</label>
                        <select name="seating_capacity" id="seating_capacity" class="form-control" required>
                            <option value="">Select Seating Capacity</option>
                            <option value="2" <?php if ($car['seating_capacity'] == '2')
                                echo 'selected'; ?>>2</option>
                            <option value="4" <?php if ($car['seating_capacity'] == '4')
                                echo 'selected'; ?>>4</option>
                            <option value="5" <?php if ($car['seating_capacity'] == '5')
                                echo 'selected'; ?>>5</option>
                            <option value="7" <?php if ($car['seating_capacity'] == '7')
                                echo 'selected'; ?>>7</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Fourth row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="rent_per_day">Rent Per Day (INR)</label>
                        <input type="number" name="rent_per_day" id="rent_per_day" class="form-control" required
                            value="<?php echo $car['rent_per_day']; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Car Image</label>
                        <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
                        <img id="imagePreview" src="<?php echo '../'.$car['images']; ?>" alt="Car Image Preview"
                            style="max-width: 100%; max-height: 200px;">
                        <input type="hidden" name="existing_image" value="<?php echo $car['images']; ?>">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Car</button>
        </form>
        </div>
        <?php
    } else {
        // Display message if car id is invalid
        echo "<div class='col-12'><p>No car found</p></div>";
    }

    // Close the statement and result set
    $stmt->close();
    $result->close();
    ?>

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