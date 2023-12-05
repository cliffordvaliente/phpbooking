<?php
include_once '../files/functions.php';
hidestatus();

// Require database connection
require_once('../databases/db.php');

/*
 * This is the Student booking page. Here the student can view free timeslots and book them.
 * The code itself is an html form last, and the php which connects the form to the database to make sure
 * all the right tables and columns are affected.
*/

// Check if the user is logged in and a student, redirect to login page if not.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Student') {
    header("Location: ../index.php");
    exit();
}

// Fetch the student's course_id
$student_id = $_SESSION['user_id'];
$courseQuery = "SELECT course_id FROM student_courses WHERE student_id = ?";
$courseStmt = $pdo->prepare($courseQuery);
$courseStmt->execute([$student_id]);
$studentCourse = $courseStmt->fetch(PDO::FETCH_ASSOC);

if (!$studentCourse) {
    // Redirect or handle error if the student is not enrolled in any course
    exit('You are not enrolled in any course.');
}

$course_id = $studentCourse['course_id'];

// Fetch available sessions for the student's course with assistant details
$sessionQuery = "SELECT gs.*, u.full_name AS assistant_name FROM guidance_sessions gs
                 JOIN users u ON gs.assistant_id = u.user_id
                 WHERE gs.course_id = ? AND gs.BookingStatus = 'Pending'";
$sessionStmt = $pdo->prepare($sessionQuery);
$sessionStmt->execute([$course_id]);
$availableSessions = $sessionStmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tilgjengelige hjelpelærerøkter</title>
    <link rel="stylesheet" href="../stylesheet/bstudent.css">
</head>

<body>
    <h2>Tilgjengelige økter</h2>
    <table border="1">
        <tr>
            <th>Hjelpelærer</th>
            <th>Lengde i minutter</th>
            <th>Tema/Modul</th>
            <th>Status</th>
            <th>Dato</th>
            <th>Booke?</th>
        </tr>
        <?php foreach ($availableSessions as $session): ?>
            <tr>
                <td>
                    <?php echo $session['assistant_name']; ?>
                </td>
                <td>
                    <?php echo $session['length']; ?>
                </td>
                <td>
                    <?php echo $session['session_theme']; ?>
                </td>
                <td>
                    <?php echo $session['BookingStatus']; ?>
                </td>
                <td>
                    <?php echo $session['bookingdate']; ?>
                </td>
                <td>
                    <form action="book_session.php" method="post">
                        <input type="hidden" name="session_id" value="<?php echo $session['session_id']; ?>">
                        <input type="submit" value="Book denne økta">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="../index.php">Tilbake til dashboard</a></p>
</body>

</html>