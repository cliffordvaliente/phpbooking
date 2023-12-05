<?php
require_once('../databases/db.php');
/* This code lets students cancel their booking, and frees the slot up for someone else to book. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $session_id = $_POST['session_id'];

    // Update guidance_sessions table to cancel the booking
    try {
        $pdo->beginTransaction();

        $updateQuery = "UPDATE guidance_sessions 
                        SET BookingStatus = 'Pending', student_id = NULL 
                        WHERE session_id = ?";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->execute([$session_id]);

        $pdo->commit();
        header("Location: ../index.php");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        // Handle and log error appropriately
        exit('An error occurred:' . $e->getMessage());
    }
}
?>