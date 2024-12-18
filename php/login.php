<?php
include('db.php'); // Connect to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? trim($_POST['username']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    // Check if user exists in database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            echo "Login successful!"; // Redirect to dashboard or home page
        } else {
            echo "Invalid username or password!";
        }
    } else {
        echo "User not found!";
    }
}
?>
