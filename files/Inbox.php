<?php
session_start();

// Include database connection code (db.inc.php)
require_once('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or perform other actions
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch the course_id for the user from student_courses table
$stmt = $pdo->prepare("SELECT course_id FROM student_courses WHERE student_id = ?");
$stmt->execute([$user_id]);
$course_id = $stmt->fetchColumn();

// Fetch Teaching Assistants for the same subject
$stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'Assistant' AND user_id IN (
                        SELECT user_id FROM student_courses WHERE course_id = ?)");
$stmt->execute([$course_id]);
$tas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Students for the same subject
$stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'Student' AND user_id IN (
                        SELECT user_id FROM student_courses WHERE course_id = ?)");
$stmt->execute([$course_id]);
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
</head>
<body>
    <h1>Welcome, <?php echo $user['username']; ?>!</h1>

    <h2>Teaching Assistants:</h2>
    <ul>
        <?php foreach ($tas as $ta): ?>
            <li><?php echo $ta['username']; ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Students:</h2>
    <ul>
        <?php foreach ($students as $student): ?>
            <li><?php echo $student['username']; ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- Add links or forms for further actions -->

</body>
</html>
