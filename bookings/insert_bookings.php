<?php
require_once('../databases/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assistant_id = $_SESSION['user_id'];
    $session_date = $_POST['session_date'];
    $start_time_input = $_POST['start_time'];
    $end_time_input = $_POST['end_time'];
    $session_theme = $_POST['session_theme'];
    $length = $_POST['length'];
    $booking_status = 'available';

    $is_12_hour_format = strpos($start_time_input, 'AM') !== false || strpos($start_time_input, 'PM') !== false;

    // Convert start_time and end_time to 24-hour format
    if ($is_12_hour_format) {
        $start_time_24h = date('H:i', strtotime($start_time_input));
        $end_time_24h = date('H:i', strtotime($end_time_input));
    } else {
        // If it's already in 24-hour format, no conversion needed
        $start_time_24h = $start_time_input;
        $end_time_24h = $end_time_input;
    }

    // Additional validation and data insertion goes here
    // Use prepared statements and handle errors appropriately
    // ...

    // Sample insertion code (replace with actual database insert code)
    $query = "INSERT INTO guidance_sessions (assistant_id, length, session_theme, InfoDate, BookingStatus)
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$assistant_id, $length, $session_theme, $session_date . ' ' . $start_time_24h, $booking_status]);

    // Redirect or handle success appropriately
    header("Location: set_timeslots.php");
    exit();
}
?>
