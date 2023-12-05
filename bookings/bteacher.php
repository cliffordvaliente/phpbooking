<?php
include_once '../files/functions.php';
hidestatus();

// Require database connection
require_once('../databases/db.php');

// Check if the user is logged in and a teaching assistant, redirect to login page if not.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Assistant') {
header("Location: ../index.php");
exit();
}
    // Booking form handling
$errormessage = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $session_date = $_POST['session_date'];
    $start_time_input = $_POST['start_time'];
    $session_theme = $_POST['session_theme'];
    $length = $_POST['length'];
    $course_id = $_POST['course_id'];

    $is_12_hour_format = strpos($start_time_input, 'AM') !== false || strpos($start_time_input, 'PM') !== false;

    // Convert start_time to 24-hour format for AM/PM users
    if ($is_12_hour_format) {
        $start_time_24h = date('H:i', strtotime($start_time_input));
    } else {
        // If it's already in 24-hour format, no conversion needed
        $start_time_24h = $start_time_input;
    }

    // Additional validation
    if (empty($session_date)) {
        $error[] = "Vennligst sett en dato";
    }
    if (empty($start_time_24h)) {
        $error[] = "Vennligst sett et starttidspunkt";
    }
    if (empty($session_theme)) {
        $error[] = "Vennligst sett et tema/modul";
    }
    if (empty($length) || !is_numeric($length) || $length <= 0) {
        $error[] = "Vennligst sett lengde for økten";
    }
    if (empty($course_id)) {
        $error[] = "Vennligst velg et kurs";
    }

    if (empty($error)) {
        include('insert_booking.php');
        exit();
    } else {
        echo "Feil oppstod, vennligst rett på følgende:<br>";
        foreach ($error as $errormessage) {
            echo "-$errormessage<br>";
        }
    }
}

// Fetch the courses associated with the logged-in TA
$assistant_id = $_SESSION['user_id'];
$courseQuery = "SELECT c.course_id, c.course_name FROM courses c
                INNER JOIN student_courses sc ON c.course_id = sc.course_id
                WHERE sc.student_id = ?";
$courseStmt = $pdo->prepare($courseQuery);
$courseStmt->execute([$assistant_id]);
$availableCourses = $courseStmt->fetchAll(PDO::FETCH_ASSOC);

include('display_bteacher.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sett opp veiledningsøkter</title>
</head>
<body>
    <h2>Sett opp veiledningsøkter</h2>
    <form action="" method="post" novalidate>
        <label>Dato:</label>
        <input type="date" name="session_date" required><br>

        <label>Start klokken:</label>
        <input type="time" name="start_time" required><br>

        <label>Tema/Modul(er):</label>
        <input type="text" name="session_theme" required><br>

        <label>Lengde (i minutter):</label>
        <input type="number" name="length" required><br>

        <label>Velg kurs:</label>
        <select name="course_id" required>
            <?php foreach ($availableCourses as $course): ?>
                <option value="<?php echo $course['course_id']; ?>"><?php echo $course['course_name']; ?></option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Sett opp en veiledningstime">
    </form>
    <p><a href="../index.php">Tilbake til dashbord</a></p>
</body>
</html>