<?php
include_once '../files/functions.php';
hidestatus();

// Require database connection
require_once('../databases/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_SESSION['user_id'];
    $session_id = $_POST['session_id'];

    // Fetch student_id from the students table based on user_id
    $studentQuery = "SELECT student_id FROM students WHERE user_id = ?";
    $studentStmt = $pdo->prepare($studentQuery);
    $studentStmt->execute([$student_id]);
    $studentData = $studentStmt->fetch(PDO::FETCH_ASSOC);

    if ($studentData) {
        $student_id = $studentData['student_id'];

        // Update guidance_sessions table to book the session
        try {
            $pdo->beginTransaction();

            // Check if the session is still 'Pending' before updating
            $checkQuery = "SELECT * FROM guidance_sessions WHERE session_id = ? AND BookingStatus = 'Pending' LIMIT 1";
            $checkStmt = $pdo->prepare($checkQuery);
            $checkStmt->execute([$session_id]);

            if ($checkStmt->rowCount() > 0) {
                // Session is still 'Pending', proceed with the update
                $updateQuery = "UPDATE guidance_sessions SET BookingStatus = 'Confirmed', student_id = ? WHERE session_id = ?";
                $stmt = $pdo->prepare($updateQuery);
                $stmt->execute([$student_id, $session_id]);

                $pdo->commit();
                header("Location: bstudent.php");
                exit();
            } else {
                // Session not found or already booked
                $pdo->rollBack();
                exit('Session not found or already booked.');
            }
        } catch (Exception $e) {
            $pdo->rollBack();
            // Handle and log error appropriately
            exit('An error occurred: ' . $e->getMessage());
        }
    } else {
        // Handle error if student_id is not found
        exit('Student ID not found.');
    }
}
?>
