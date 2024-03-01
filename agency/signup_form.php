<?php
// Check for errors in session and initialize variables
$errors = [
    "agencyUsername_err" => "",
    "agencyPassword_err" => "",
    "agencyEmail_err" => "",
    "agencyName_err" => "",
    "agencyAddress_err" => "",
    "agencyMobile_err" => ""
];

foreach ($errors as $key => $value) {
    if (isset($_SESSION[$key])) {
        $errors[$key] = $_SESSION[$key];
        unset($_SESSION[$key]); // Clear the error message after displaying
    }
}

// Initialize variables for pre-filled values
$prefilled_values = [
    "agencyUsername" => "",
    "agencyEmail" => "",
    "agencyName" => "",
    "agencyAddress" => "",
    "agencyMobile" => ""
];

// Retrieve pre-filled values from session
foreach ($prefilled_values as $key => $value) {
    if (isset($_SESSION[$key . "_value"])) {
        $prefilled_values[$key] = $_SESSION[$key . "_value"];
        unset($_SESSION[$key . "_value"]); // Clear the pre-filled value after displaying
    }
}
?>

<form action="agency/signup.php" method="POST">
    <div class="form-group">
        <label for="agencyUsername">Username:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" id="agencyUsername" name="agencyUsername" value="<?php echo $prefilled_values['agencyUsername']; ?>" required>
        </div>
        <?php if(!empty($errors["agencyUsername_err"])): ?>
            <span class="text-danger"><?php echo $errors["agencyUsername_err"]; ?></span>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="agencyPassword">Password:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" class="form-control" id="agencyPassword" name="agencyPassword" required>
        </div>
        <?php if(!empty($errors["agencyPassword_err"])): ?>
            <span class="text-danger"><?php echo $errors["agencyPassword_err"]; ?></span>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="agencyEmail">Email:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="email" class="form-control" id="agencyEmail" name="agencyEmail" value="<?php echo $prefilled_values['agencyEmail']; ?>" required>
        </div>
        <?php if(!empty($errors["agencyEmail_err"])): ?>
            <span class="text-danger"><?php echo $errors["agencyEmail_err"]; ?></span>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="agencyName">Name:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control" id="agencyName" name="agencyName" value="<?php echo $prefilled_values['agencyName']; ?>" required>
        </div>
        <?php if(!empty($errors["agencyName_err"])): ?>
            <span class="text-danger"><?php echo $errors["agencyName_err"]; ?></span>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="agencyAddress">Office Address:</label>
        <textarea class="form-control" id="agencyAddress" name="agencyAddress" rows="3"><?php echo $prefilled_values['agencyAddress']; ?></textarea>
        <?php if(!empty($errors["agencyAddress_err"])): ?>
            <span class="text-danger"><?php echo $errors["agencyAddress_err"]; ?></span>
        <?php endif; ?>
    </div>
    <div class="form-group">
        <label for="agencyMobile">Mobile:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
            </div>
            <input type="text" class="form-control" id="agencyMobile" name="agencyMobile" value="<?php echo $prefilled_values['agencyMobile']; ?>" required>
        </div>
        <?php if(!empty($errors["agencyMobile_err"])): ?>
            <span class="text-danger"><?php echo $errors["agencyMobile_err"]; ?></span>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary ">Sign Up</button>
</form>
