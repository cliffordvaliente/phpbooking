<?php
//! DATABASE STUFF
require_once('../databases/db.php');

//! THE SCRIPT TO RUN TO INSERT THE INFO TO THE DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assistant_id = $_SESSION['user_id'];
    $session_date = $_POST['session_date'];
    $start_time_input = $_POST['start_time'];
    $session_theme = $_POST['session_theme'];
    $length = $_POST['length'];
    $booking_status = 'Pending'; //! DEFAULT STATUS

    //! FETCH course_id BASED ON THE SELECTED COURSE IN THE FORM
    $course_id = $_POST['course_id'];

    //! BUILD CONSTRUCT BOOKING DATE FROM START TIME AND SESSION DATE TOGETHER AS 1 FOR THE DB LATER !! CONCATINATE
    $booking_date_str = $session_date . ' ' . $start_time_input;
    $booking_date = date('Y-m-d H:i:s', strtotime($booking_date_str));

    //! INSERT THE INFORMATION TO THE DATABASE
    try {
        $pdo->beginTransaction();
        //! SQL SCRIPT TO INSERT IN THE DATABASE
        //! PDO THIS TYPE ON INSERTING USING PDO IS SECURED AGAINST SQL INJECTION THUS WE HAVE AS WE SEE VALUES QUESTION MARKS "?"
        $query = "INSERT INTO guidance_sessions (assistant_id, course_id, length, session_theme, BookingStatus, bookingdate)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$assistant_id, $course_id, $length, $session_theme, $booking_status, $booking_date]);
        //! COMMIT TO DB
        $pdo->commit();
        //! AFTER INSERTED GO BACK TO HEADER
        header("Location: bteacher.php");

    } catch (Exception $e) {
        $pdo->rollBack();
        // Handle and log error appropriately
        exit('Her gikk noe galt:' . $e->getMessage());
    }
}
?>