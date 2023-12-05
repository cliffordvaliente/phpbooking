<?php
require_once('../databases/db.php');
/* This code lets TAs delete their booking, removing it from availability. */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $session_id = $_POST['session_id'];

    // Delete session from guidance_sessions table
    try {
        $pdo->beginTransaction();

        $deleteQuery = "DELETE FROM guidance_sessions WHERE session_id = ?";
        $stmt = $pdo->prepare($deleteQuery);
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