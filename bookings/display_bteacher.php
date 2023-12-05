<?php
require_once('../databases/db.php');

// Fetch TA bookings
$assistant_id = $_SESSION['user_id'];

$bookingsQuery = "SELECT gs.*, u.full_name AS student_name
                  FROM guidance_sessions gs
                  JOIN students s ON gs.student_id = s.student_id
                  JOIN users u ON s.user_id = u.user_id
                  WHERE gs.assistant_id = ?";
$bookingsStmt = $pdo->prepare($bookingsQuery);
$bookingsStmt->execute([$assistant_id]);
$assistantBookings = $bookingsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Your Bookings</h2>
<table border="1">
    <tr>
        <th>Student</th>
        <th>Lengde i minutter</th>
        <th>Tema/Modul</th>
        <th>Status</th>
        <th>Dato</th>
        <th>Kanseller (og slett)</th>
    </tr>
    <?php foreach ($assistantBookings as $booking): ?>
        <tr>
            <td><?php echo $booking['student_name']; ?></td>
            <td><?php echo $booking['length']; ?></td>
            <td><?php echo $booking['session_theme']; ?></td>
            <td><?php echo $booking['BookingStatus']; ?></td>
            <td><?php echo $booking['bookingdate']; ?></td>
            <td>
                <form action="cancel_session.php" method="post">
                    <input type="hidden" name="session_id" value="<?php echo $booking['session_id']; ?>">
                    <input type="submit" value="Cancel Session">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
