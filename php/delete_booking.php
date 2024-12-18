<?php
include('db.php');

// Initialize response array
$response = ['status' => 'error', 'message' => 'Something went wrong.'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the booking from the database
    $sql = "DELETE FROM bookings WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    $response['status'] = 'success';
    $response['message'] = 'Booking deleted successfully!';
} else {
    $response['message'] = 'Invalid request.';
}

// Return JSON response
echo json_encode($response);
?>
