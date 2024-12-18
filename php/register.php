<?php
ini_set('display_errors', 1);
ini_set('display_start_errors', 1);
error_reporting(E_ALL);

include('db.php'); // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;
    $error = [];

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Please enter a valid email';
    }

    // Validate username
    if (empty($username) || strlen($username) < 3) {
        $error[] = 'Please enter a valid username';
    }

    // Validate password
    if (empty($password) || strlen($password) < 6) {
        $error[] = 'Please enter a valid password (min 6 characters)';
    }

    // If there are errors, redirect to registration page
    if (!empty($error)) {
        session_start();
        $_SESSION['error'] = $error;
        header('Location: ../login.html'); // Redirect to the login page
        exit();
    }

    // If validation passes, hash the password
    $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

    // Escape user inputs to prevent SQL injection
    $email = $conn->real_escape_string($email);
    $username = $conn->real_escape_string($username);

    // Insert data into the database
    $sql = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$hashedpassword')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful. You can now <a href='../login.php'>log in</a>"; // Display success message
    } else {
        echo "Error: " . $conn->error; // Display error if something went wrong
    }
}
?>
