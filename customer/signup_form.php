<?php

// Check for errors in session and initialize variables
$errors = [
    "customerUsername_err" => "",
    "customerPassword_err" => "",
    "customerEmail_err" => "",
    "customerName_err" => "",
    "customerMobile_err" => ""
];

// Pre-filled values array
$prefilled_values = [
    "customerUsername" => "",
    "customerEmail" => "",
    "customerName" => "",
    "customerMobile" => ""
];

foreach ($errors as $key => $value) {
    if (isset($_SESSION[$key])) {
        $errors[$key] = $_SESSION[$key];
        unset($_SESSION[$key]); // Clear the error message after displaying
    }
}

// Check for pre-filled values in session
foreach ($prefilled_values as $key => $value) {
    if (isset($_SESSION[$key . "_value"])) {
        $prefilled_values[$key] = $_SESSION[$key . "_value"];
        unset($_SESSION[$key . "_value"]); // Clear the pre-filled value after displaying
    }
}
?>

<form action="customer/signup.php" method="POST">
    <div class="form-group">
        <label for="customerUsername">Username:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" id="customerUsername" name="customerUsername" value="<?php echo $prefilled_values['customerUsername']; ?>" required>
        </div>
        <span class="text-danger"><?php echo $errors["customerUsername_err"]; ?></span>
    </div>
    <div class="form-group">
        <label for="customerPassword">Password:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" class="form-control" id="customerPassword" name="customerPassword" required>
        </div>
        <span class="text-danger"><?php echo $errors["customerPassword_err"]; ?></span>
    </div>
    <div class="form-group">
        <label for="customerEmail">Email:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="email" class="form-control" id="customerEmail" name="customerEmail" value="<?php echo $prefilled_values['customerEmail']; ?>" required>
        </div>
        <span class="text-danger"><?php echo $errors["customerEmail_err"]; ?></span>
    </div>
    <div class="form-group">
        <label for="customerName">Name:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" id="customerName" name="customerName" value="<?php echo $prefilled_values['customerName']; ?>" required>
        </div>
        <span class="text-danger"><?php echo $errors["customerName_err"]; ?></span>
    </div>
    <div class="form-group">
        <label for="customerMobile">Mobile:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
            </div>
            <input type="text" class="form-control" id="customerMobile" name="customerMobile" value="<?php echo $prefilled_values['customerMobile']; ?>" required>
        </div>
        <span class="text-danger"><?php echo $errors["customerMobile_err"]; ?></span>
    </div>
    <button type="submit" class="btn btn-primary">Sign Up</button>
</form>
