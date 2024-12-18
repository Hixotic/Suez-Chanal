<?php
include 'db2.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $booking_time = $_POST['booking_time'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = 'uploads/';
        $image_path = $upload_dir . basename($image_name);

        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            echo "Error uploading the image.";
            exit;
        }
    } else {
        $image_path = '';
    }

    $sql = "INSERT INTO bookings (name, email, image, booking_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$name, $email, $image_path, $booking_time]);

    echo $stmt->rowCount() > 0 ? "Booking added successfully!" : "Error: " . $stmt->errorInfo()[2];
}
?>
