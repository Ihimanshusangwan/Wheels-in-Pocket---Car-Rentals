<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../config.php";

    // Define variables and initialize with empty values
    $username = $password = $email = $name = $address = $mobile = "";
    $username_err = $password_err = $email_err = $name_err = $address_err = $mobile_err = "";
    // Store input values in session for pre-filling the form in case of errors
    $_SESSION["agencyUsername_value"] = $_POST["agencyUsername"];
    $_SESSION["agencyEmail_value"] = $_POST["agencyEmail"];
    $_SESSION["agencyName_value"] = $_POST["agencyName"];
    $_SESSION["agencyAddress_value"] = $_POST["agencyAddress"];
    $_SESSION["agencyMobile_value"] = $_POST["agencyMobile"];

    // Validate username
    if (empty(trim($_POST["agencyUsername"]))) {
        $_SESSION["agencyUsername_err"] = "Please enter a username.";
    } else {
        $sql = "SELECT agency_id FROM agencies WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {

            $param_username = trim($_POST["agencyUsername"]);
            $stmt->bind_param("s", $param_username);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $_SESSION["agencyUsername_err"] = "This username is already taken.";
                } else {
                    $username = trim($_POST["agencyUsername"]);
                }
            } else {
                $_SESSION["agencyUsername_err"] = "Oops! Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

    // Validate password
    if (empty(trim($_POST["agencyPassword"]))) {
        $_SESSION["agencyPassword_err"] = "Please enter a password.";
    } else {
        $password = trim($_POST["agencyPassword"]);
    }

    // Validate email
    if (empty(trim($_POST["agencyEmail"]))) {
        $_SESSION["agencyEmail_err"] = "Please enter an email address.";
    } else {
        $email = trim($_POST["agencyEmail"]);
    }

    // Validate name
    if (empty(trim($_POST["agencyName"]))) {
        $_SESSION["agencyName_err"] = "Please enter your name.";
    } else {
        $name = trim($_POST["agencyName"]);
    }

    // Validate address
    if (empty(trim($_POST["agencyAddress"]))) {
        $_SESSION["agencyAddress_err"] = "Please enter your office address.";
    } else {
        $address = trim($_POST["agencyAddress"]);
    }

    // Validate mobile
    if (empty(trim($_POST["agencyMobile"]))) {
        $_SESSION["agencyMobile_err"] = "Please enter your mobile number.";
    } else {
        $mobile = trim($_POST["agencyMobile"]);
    }

    // Check input errors before inserting into database
    if (empty($_SESSION["agencyUsername_err"]) && empty($_SESSION["agencyPassword_err"]) && empty($_SESSION["agencyEmail_err"]) && empty($_SESSION["agencyName_err"]) && empty($_SESSION["agencyAddress_err"]) && empty($_SESSION["agencyMobile_err"])) {
        // Prepare an insert statement
        $sql = "INSERT INTO agencies (username, password, email, name, address, mobile) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $email;
            $param_name = $name;
            $param_address = $address;
            $param_mobile = $mobile;

            $stmt->bind_param("ssssss", $param_username, $param_password, $param_email, $param_name, $param_address, $param_mobile);

            if ($stmt->execute()) {
                // Clear any existing error messages and input values
                unset(
                    $_SESSION["agencyUsername_err"],
                    $_SESSION["agencyPassword_err"],
                    $_SESSION["agencyEmail_err"],
                    $_SESSION["agencyName_err"],
                    $_SESSION["agencyAddress_err"],
                    $_SESSION["agencyMobile_err"],
                    $_SESSION["agencyUsername_value"],
                    $_SESSION["agencyEmail_value"],
                    $_SESSION["agencyName_value"],
                    $_SESSION["agencyAddress_value"],
                    $_SESSION["agencyMobile_value"]
                    );

                // Set success message in session
                $_SESSION["success_message"] = "You have signed up successfully!";

                // Redirect to login page
                header("location: ../signin.php?tab=agency");
                exit();
            } else {
                $_SESSION["err_message"] = "Oops! Something went wrong. Please try again later.";
                header("location: ../signup.php?tab=agency");

            }

            $stmt->close();
        }
    } else {
        // Redirect back to sign-up page with errors and select the "Agency" tab
        header("location: ../signup.php?tab=agency");
        exit();
    }

    // Close connection
    $conn->close();
}
