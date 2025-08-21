<?php
require_once 'db_config.php';
header('Content-Type: application/json');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    if (!$data) throw new Exception('Invalid input data');

    $sql = "INSERT INTO bookings (
        booking_reference, full_name, email, phone, checkin_date, checkout_date, num_guests, resort_name, price
    ) VALUES (
        :ref, :name, :email, :phone, :checkin, :checkout, :guests, :resort, :price
    )";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':ref' => $data['booking_reference'],
        ':name' => $data['full_name'],
        ':email' => $data['email'],
        ':phone' => $data['phone'],
        ':checkin' => $data['checkin'],
        ':checkout' => $data['checkout'],
        ':guests' => $data['guests'],
        ':resort' => $data['resort_name'],
        ':price' => $data['price']
    ]);
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        throw new Exception('Failed to create booking');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}