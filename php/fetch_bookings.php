<?php
include('db.php');

header('Content-Type: application/json');

// Initialize response array
$response = ['status' => 'error', 'message' => 'Could not fetch bookings.'];

try {
    // Fetch all bookings from the database
    $sql = "SELECT * FROM bookings";
    $stmt = $pdo->query($sql);

    $bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($bookings) {
        $response['status'] = 'success';
        $response['data'] = $bookings;
    } else {
        $response['message'] = 'No bookings found.';
    }
} catch (Exception $e) {
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Return JSON response
echo json_encode($response);
?>
