<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Wheels in Pocket</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
    <div class="container mt-5 col-md-4">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="customer-tab" data-toggle="tab" href="#customer" role="tab"
                    aria-controls="customer" aria-selected="true">Sign Up as Customer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="agency-tab" data-toggle="tab" href="#agency" role="tab" aria-controls="agency"
                    aria-selected="false">Sign Up as Agency</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Customer Sign Up Form -->
            <div class="tab-pane fade show active" id="customer" role="tabpanel" aria-labelledby="customer-tab">
                <div class="card mt-3">
                    
                    <h5 class="card-header"><i class="fas fa-user"></i> Customer Sign Up</h5>
                    <div class="card-body">
                        <?php  include_once('customer/signup_form.php') ?>
                        <div class="text-center mt-3">Already have an account? <a href="signin.php">Sign in</a></div>
                    </div>
                </div>
            </div>

            <!-- Agency Sign Up Form -->
            <div class="tab-pane fade" id="agency" role="tabpanel" aria-labelledby="agency-tab">
                <div class="card mt-3">
                    <h5 class="card-header"><i class="fas fa-building"></i> Agency Sign Up</h5>
                    <div class="card-body">
    
                    <?php  include_once('agency/signup_form.php') ?>
                        <div class="text-center mt-3">Already have an account? <a href="signin.php?tab=agency">Sign in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
      $(document).ready(function(){
        // Check if the URL contains the "tab" query parameter
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        
        // If the "tab" parameter is set to "agency", activate the "Agency" tab
        if(tab === "agency"){
            $('#agency-tab').tab('show');
        }
    });
</script>

</body>

</html>