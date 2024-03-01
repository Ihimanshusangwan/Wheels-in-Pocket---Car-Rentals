<?php
session_destroy();
session_start();

require_once "../config.php";

// Initialize variables
$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["agencyUsername"]))) {
        $_SESSION["agencyUsername_err"] = "Please enter your username.";
    } else {
        $username = trim($_POST["agencyUsername"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["agencyPassword"]))) {
        $_SESSION["agencyPassword_err"] = "Please enter your password.";
    } else {
        $password = trim($_POST["agencyPassword"]);
    }

    // Validate credentials
    if (empty($_SESSION["agencyUsername_err"]) && empty($_SESSION["agencyPassword_err"])) {
        $sql = "SELECT agency_id, username, password FROM Agencies WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
            $param_username = $username;
            $stmt->bind_param("s", $param_username);
            if ($stmt->execute()) {
                $stmt->store_result();
                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($agency_id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_unset();
                            session_destroy();
                            session_start();
                            $_SESSION["agency_id"] = $agency_id;
                            $_SESSION["username"] = $username;

                            // Redirect user to dashboard page
                            header("location: dashboard.php");
                            exit;
                        } else {
                            // Set password error message in session
                            $_SESSION["agencyPassword_err"] = "The password you entered is not valid.";
                            $_SESSION["previous_valid_username"] = $username;
                        }
                    }
                } else {
                    // Set username error message in session
                    $_SESSION["agencyUsername_err"] = "No account found with that username.";
                    $_SESSION["previous_valid_username"] = $username;
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}

// Redirect back to login page in case of error
header("location: ../signin.php?tab=agency");
exit;

