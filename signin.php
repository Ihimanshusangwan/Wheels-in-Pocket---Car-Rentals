<?php
session_start();

if (isset($_SESSION["agency_id"])) {
    // Redirect to agency dashboard
    header("location: agency/dashboard.php");
    exit;
} elseif (isset($_SESSION["customer_id"])) {
    // Redirect to customer dashboard
    header("location: customer/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Wheels in Pocket</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <div class="container mt-5 col-md-4">

        <?php
        // Check if success message exists in session
        if (isset($_SESSION["success_message"])) {
            // Display the success message
            echo '<div class="alert alert-success" role="alert">' . $_SESSION["success_message"] . '</div>';
            // Clear the success message from the session
            unset($_SESSION["success_message"]);
        }
        ?>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer" role="tab"
                    aria-controls="customer" aria-selected="true">Sign In as Customer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="agency-tab" data-toggle="tab" href="#agency" role="tab" aria-controls="agency"
                    aria-selected="false">Sign In as Agency</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Customer Sign In Form -->
            <div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                <div class="card mt-3">
                    <h5 class="card-header"><i class="fas fa-user"></i> Customer Sign In</h5>
                    <div class="card-body">
                        <form action="customer/login.php" method="POST">
                            <div class="form-group">
                                <label for="customerUsername">Username:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="customerUsername"
                                        name="customerUsername" required
                                        value="<?php if (isset($_SESSION["previous_customerUsername"])) {
                                            echo htmlspecialchars($_SESSION["previous_customerUsername"]);
                                            unset($_SESSION["previous_customerUsername"]);
                                        } ?>">
                                </div>
                                <?php if (isset($_SESSION["customerUsername_err"])): ?>
                                    <span class="text-danger">
                                        <?php echo $_SESSION["customerUsername_err"]; ?>
                                    </span>
                                    <?php unset($_SESSION["customerUsername_err"]); ?>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="customerPassword">Password:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="customerPassword"
                                        name="customerPassword" required>
                                </div>
                                <?php if (isset($_SESSION["customerPassword_err"])): ?>
                                    <span class="text-danger">
                                        <?php echo $_SESSION["customerPassword_err"]; ?>
                                    </span>
                                    <?php unset($_SESSION["customerPassword_err"]); ?>
                                <?php endif; ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </form>



                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agency Sign In Form -->
            <div class="tab-pane fade" id="agency" role="tabpanel" aria-labelledby="agency-tab">
                <div class="card mt-3">
                    <h5 class="card-header"><i class="fas fa-building"></i> Agency Sign In</h5>
                    <div class="card-body">
                        <form action="agency/login.php" method="POST">
                            <div class="form-group">
                                <label for="agencyUsername">Username:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="agencyUsername"
                                        name="agencyUsername" required
                                        value="<?php if (isset($_SESSION["previous_valid_username"])) {
                                            echo htmlspecialchars($_SESSION["previous_valid_username"]);
                                            unset($_SESSION["previous_valid_username"]);
                                        } ?>">
                                </div>
                                <?php if (isset($_SESSION["agencyUsername_err"])) { ?>
                                    <span class="text-danger">
                                        <?php echo $_SESSION["agencyUsername_err"]; ?>
                                    </span>
                                    <?php unset($_SESSION["agencyUsername_err"]); ?>
                                <?php } ?>
                            </div>
                            <div class="form-group">
                                <label for="agencyPassword">Password:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="agencyPassword"
                                        name="agencyPassword" required>
                                </div>
                                <?php if (isset($_SESSION["agencyPassword_err"])) { ?>
                                    <span class="text-danger">
                                        <?php echo $_SESSION["agencyPassword_err"]; ?>
                                    </span>
                                    <?php unset($_SESSION["agencyPassword_err"]); ?>
                                <?php } ?>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </form>

                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="signup.php?tab=agency">Sign Up</a></p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Check if the URL contains the "tab" query parameter
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');

            // If the "tab" parameter is set to "agency", activate the "Agency" tab
            if (tab === "agency") {
                $('#agency-tab').tab('show');
            }
        });
    </script>
</body>

</html>