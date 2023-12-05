<?php
include_once './files/functions.php';
cleanupExpiredBookings($pdo);
require_once('./databases/db.php');
// Fetch student bookings
$student_id = $_SESSION['user_id'];

$bookingsQuery = "SELECT gs.*, u.full_name AS assistant_name
                  FROM guidance_sessions gs
                  JOIN students s ON gs.student_id = s.student_id
                  JOIN users u ON gs.assistant_id = u.user_id
                  WHERE s.user_id = ?";
$bookingsStmt = $pdo->prepare($bookingsQuery);
$bookingsStmt->execute([$student_id]);
$studentBookings = $bookingsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Dine kommende økter</h2>
<table border="1">
    <tr>
        <th>Hjelpelærer</th>
        <th>Lengde i minutter</th>
        <th>Tema/Modul</th>
        <th>Status</th>
        <th>Dato</th>
        <th>Kansellere?</th>
    </tr>
    <?php foreach ($studentBookings as $booking): ?>
        <tr>
            <td><?php echo $booking['assistant_name']; ?></td>
            <td><?php echo $booking['length']; ?></td>
            <td><?php echo $booking['session_theme']; ?></td>
            <td><?php echo $booking['BookingStatus']; ?></td>
            <td><?php echo $booking['bookingdate']; ?></td>
            <td>
                <form action="cancel_booking.php" method="post">
                    <input type="hidden" name="session_id" value="<?php echo $booking['session_id']; ?>">
                    <input type="submit" value="Cancel Booking">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
