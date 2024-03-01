<?php
session_start();
require_once "../config.php";

// Initialize variables
$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username is empty
    if (empty(trim($_POST["customerUsername"]))) {
        $_SESSION["customerUsername_err"] = "Please enter your username.";
    } else {
        $username = trim($_POST["customerUsername"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["customerPassword"]))) {
        $_SESSION["customerPassword_err"] = "Please enter your password.";
    } else {
        $password = trim($_POST["customerPassword"]);
    }

    // Validate credentials
    if (empty($_SESSION["customerUsername_err"]) && empty($_SESSION["customerPassword_err"])) {
        $sql = "SELECT customer_id, username, password FROM customers WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
            $param_username = $username;
            $stmt->bind_param("s", $param_username);
            if ($stmt->execute()) {
                $stmt->store_result();
                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($customer_id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_destroy();
                            session_start();
                            $_SESSION["customer_id"] = $customer_id;
                            $_SESSION["username"] = $username;

                            // Redirect user to customer dashboard page
                            header("location: ../index.php");
                            exit;
                        } else {
                            // Display an error message if password is not valid
                            $_SESSION["customerPassword_err"] = "The password you entered is not valid.";
                            $_SESSION["previous_customerUsername"] = $username;
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $_SESSION["customerUsername_err"] = "No account found with that username.";
                    $_SESSION["previous_customerUsername"] = $username;
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
header("location: ../signin.php");
exit;

