<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "../config.php";

    // Define variables and initialize with empty values
    $username = $password = $email = $name = $mobile = "";
    $username_err = $password_err = $email_err = $name_err = $mobile_err = "";

        // Store posted values in session for repopulating the form in case of errors
        $_SESSION["customerUsername_value"] = $_POST["customerUsername"];
        $_SESSION["customerEmail_value"] = $_POST["customerEmail"];
        $_SESSION["customerName_value"] = $_POST["customerName"];
        $_SESSION["customerMobile_value"] = $_POST["customerMobile"];

    // Validate username
    if (empty(trim($_POST["customerUsername"]))) {
        $username_err = "Please enter a username.";
    } else {
        $sql = "SELECT customer_id FROM Customers WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
            $param_username = trim($_POST["customerUsername"]);
            $stmt->bind_param("s", $param_username);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["customerUsername"]);
                }
            } else {
                $_SESSION["err_message"] = "Oops! Something went wrong. Please try again later.";
                header("location: signup.php?tab=customer");
                exit();
            }

            $stmt->close();
        }
    }

    // Validate password
    if (empty(trim($_POST["customerPassword"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["customerPassword"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["customerPassword"]);
    }

    // Validate email
    if (empty(trim($_POST["customerEmail"]))) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var(trim($_POST["customerEmail"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        $email = trim($_POST["customerEmail"]);
    }

    // Validate name
    if (empty(trim($_POST["customerName"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["customerName"]);
    }

    // Validate mobile
    if (empty(trim($_POST["customerMobile"]))) {
        $mobile_err = "Please enter your mobile number.";
    } elseif (!preg_match('/^[0-9]{10}$/', trim($_POST["customerMobile"]))) {
        $mobile_err = "Mobile number must be 10 digits without spaces or special characters.";
    } else {
        $mobile = trim($_POST["customerMobile"]);
    }

    // Check input errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($email_err) && empty($name_err) && empty($mobile_err)) {
        
        $sql = "INSERT INTO Customers (username, password, email, name, mobile) VALUES (?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $email;
            $param_name = $name;
            $param_mobile = $mobile;
            
            $stmt->bind_param("sssss", $param_username, $param_password, $param_email, $param_name, $param_mobile);
            
            if ($stmt->execute()) {
                // Unset other session variables before setting success message
                unset(
                    $_SESSION["customerUsername_err"],
                    $_SESSION["customerPassword_err"],
                    $_SESSION["customerEmail_err"],
                    $_SESSION["customerName_err"],
                    $_SESSION["customerMobile_err"],
                    $_SESSION["err_message"],
                    $_SESSION["customerUsername_value"],
                    $_SESSION["customerEmail_value"],
                    $_SESSION["customerName_value"],
                    $_SESSION["customerMobile_value"]
                );
                
                // Set success message in session
                $_SESSION["success_message"] = "You have signed up successfully!";
                header("location: ../signin.php");
                
            } else {
                $_SESSION["err_message"] = "Oops! Something went wrong. Please try again later.";
                header("location: ../signup.php");
                
            }

            $stmt->close();
        }
    } else {
        // Store errors in session
        $_SESSION["customerUsername_err"] = $username_err;
        $_SESSION["customerPassword_err"] = $password_err;
        $_SESSION["customerEmail_err"] = $email_err;
        $_SESSION["customerName_err"] = $name_err;
        $_SESSION["customerMobile_err"] = $mobile_err;

        // Redirect back to sign-up page with errors 
        header("location: ../signup.php");
        exit();
    }

    // Close connection
    $conn->close();
}

