<?php
require_once 'db_config.php';
$stmt = $pdo->query("SELECT * FROM bookings ORDER BY booking_date DESC");
$bookings = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <h1 class="text-2xl font-bold mb-6">My Bookings</h1>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th>Reference</th><th>Name</th><th>Email</th><th>Check-in</th>
                <th>Check-out</th><th>Guests</th><th>Resort</th><th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $b): ?>
            <tr>
                <td><?= htmlspecialchars($b['booking_reference']) ?></td>
                <td><?= htmlspecialchars($b['full_name']) ?></td>
                <td><?= htmlspecialchars($b['email']) ?></td>
                <td><?= htmlspecialchars($b['checkin_date']) ?></td>
                <td><?= htmlspecialchars($b['checkout_date']) ?></td>
                <td><?= htmlspecialchars($b['num_guests']) ?></td>
                <td><?= htmlspecialchars($b['resort_name']) ?></td>
                <td>৳<?= number_format($b['price'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>