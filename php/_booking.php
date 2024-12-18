<?php
include('db.php');

// Initialize response array
$response = ['status' => 'error', 'message' => 'Something went wrong.'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['time'])) {
            throw new Exception('Missing required fields.');
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $booking_time = $_POST['time'];

        // Handle the uploaded image
        if (isset($_FILES['image'])) {
            $image = $_FILES['image'];
            $imageName = time() . '_' . basename($image['name']);
            $imagePath = 'uploads/' . $imageName;

            if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                // Save the booking information to the database
                $sql = "INSERT INTO bookings (name, email, image, booking_time) VALUES (:name, :email, :image, :booking_time)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':image' => $imagePath,
                    ':booking_time' => $booking_time
                ]);

                $response['status'] = 'success';
                $response['message'] = 'Booking saved successfully!';
            } else {
                throw new Exception('Failed to upload image.');
            }
        } else {
            throw new Exception('No image uploaded.');
        }
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();  // Detailed error message
}

// Return JSON response
echo json_encode($response);
?>
