<?php
include 'db2.php';  // تضمين الاتصال بقاعدة البيانات

// استعلام SQL لاختيار جميع الحجوزات
$sql = "SELECT * FROM bookings";
$stmt = $conn->query($sql);

// جلب جميع الحجوزات على شكل مصفوفة associative
$bookings = $stmt-> fetchAll(PDO::FETCH_ASSOC);

// إرجاع البيانات بتنسيق JSON
echo json_encode($bookings);

?>
