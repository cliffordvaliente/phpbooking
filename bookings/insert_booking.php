<?php
require_once('../databases/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assistant_id = $_SESSION['user_id'];
    $session_date = $_POST['session_date'];
    $start_time_input = $_POST['start_time'];
    $session_theme = $_POST['session_theme'];
    $length = $_POST['length'];
    $booking_status = 'Pending'; // Default status
    // Fetch course_id based on the selected course in the form
    $course_id = $_POST['course_id'];
    // Construct booking date from start time and session date
    $booking_date_str = $session_date . ' ' . $start_time_input;
    $booking_date = date('Y-m-d H:i:s', strtotime($booking_date_str));

    // Sample insertion code (replace with actual database insert code)
    try {
        $pdo->beginTransaction();

        $query = "INSERT INTO guidance_sessions (assistant_id, course_id, length, session_theme, BookingStatus, bookingdate)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$assistant_id, $course_id, $length, $session_theme, $booking_status, $booking_date]);

        $pdo->commit();
        header("Location: bteacher.php");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        // Handle and log error appropriately
        exit('Her gikk noe galt:' . $e->getMessage());
    }
}
?>