<?php
session_start();
// Check if customer session is set
$isCustomerSession = isset($_SESSION['customer_id']) ? true : false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wheels in Pocket - Car Rental Agency</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background-image: url('hero-image.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            color: #fff;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-content {
            max-width: 600px;
        }

        .custom-btn {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
            padding: 12px 24px;
            font-size: 1.25rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .custom-btn:hover {
            background-color: #138496;
            border-color: #138496;
        }
    </style>
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
                <ul class="navbar-nav mx-auto">
                    <?php
                    // Display welcome message with username
                    if (isset($_SESSION["username"])) {
                        echo '<li class="nav-item">
                            <span class="navbar-text">Welcome  ' . $_SESSION["username"] . '</span>
                            </li>';
                    }
                    ?>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php
                    // Check if either customer ID or agency ID is set
                    if (isset($_SESSION["customer_id"]) || isset($_SESSION["agency_id"])) {
                        if (isset($_SESSION["customer_id"])){
                            echo '<li class="nav-item">
                            <a class="nav-link" href="customer/bookings.php">
                                <i class="fas fa-car"></i> Bookings
                            </a>
                          </li>';
                        }
                        if (isset($_SESSION["agency_id"])){
                            echo '<li class="nav-item">
                            <a class="nav-link" href="agency/dashboard.php">
                                 Dashboard
                            </a>
                          </li>';
                        }
                        // Display logout button
                        echo '<li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                  </li>';
                    } else {
                        // Display login and signup buttons
                        echo '<li class="nav-item">
                    <a class="nav-link" href="signin.php">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="signup.php">
                        <i class="fas fa-user-plus"></i> Sign Up
                    </a>
                  </li>';
                    }
                    ?>
                </ul>
            </div>

        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1>Welcome
                    <?php
                    // Display welcome message with username
                    if (isset($_SESSION["username"]) && isset($_SESSION["customer_id"])) {
                        echo ', ' . $_SESSION["username"];
                    }
                    ?> to Wheels in Pocket
                </h1>
                <p class="lead">Find the perfect car for your journey!</p>
                <a href="#available-cars" class="btn btn-lg custom-btn">View Available Cars</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-car fa-4x mb-3"></i>
                        <h3>Wide Range of Cars</h3>
                        <p>Choose from a variety of cars based on your preferences and needs.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-dollar-sign fa-4x mb-3"></i>
                        <h3>Affordable Prices</h3>
                        <p>Enjoy competitive rental rates for every budget.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-center">
                        <i class="fas fa-check-circle fa-4x mb-3"></i>
                        <h3>Easy Booking Process</h3>
                        <p>Book your car hassle-free with our user-friendly online platform.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Available Cars Section -->
    <section id="available-cars" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Available Cars for Rent</h2>
            <div class="container mt-5">
                <div id="carContainer" class="row"></div>
                <div id="loading" class="spinner-border text-primary" role="status" style="display: none;">
                    <span class="visually-hidden"></span>
                </div>
                <button id="moreBtn" class="btn btn-outline-secondary mt-3">
                    <i class="fas fa-plus"></i> More cars
                </button>

            </div>
        </div>
    </section>


    </div>
    </section>

    <!-- Footer Section -->
    <?php include_once("footer.php"); ?>
    <script>
        var isCustomerSession = <?php echo $isCustomerSession ? 'true' : 'false'; ?>;
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="fetch_cars.js"></script>

</body>

</html>