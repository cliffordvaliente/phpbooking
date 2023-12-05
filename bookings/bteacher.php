<?php
include_once '../files/functions.php';
hidestatus();

// Require database connection
require_once('../databases/db.php');
/*
// Check if the user is logged in and a teaching assistant, redirect to login page if not.
    header("Location: ../index.php"); // CHECK IF THIS REDIRECT IS CORRECT ##################################################
    exit();
}
*/
// Booking form handling
$error = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $session_date = $_POST['session_date'];
   $start_time_input = $_POST['start_time'];
   $end_time_input = $_POST['end_time'];
   $session_theme = $_POST['session_theme'];
   $length = $_POST['length'];

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

   // Additional validation goes here

   if (empty($error)) {
      include('../files/insert_booking.php');
      header("Location: set_timeslots.php");
      exit();
   } else {
      echo "Feil oppstod, vennligst rett på følgende:<br>";
      foreach ($error as $errormessage) {
         echo "-$errormessage<br>";
      }
   }
}

/*


// Fetch user data from the database based on the user_id stored in the session.
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <title>Sett opp veiledningsøkter</title>
</head>

<body>
   <h2>Sett opp veiledningsøkter</h2>
   <form action="handle_timeslots.php" method="post">
      <label>Dato:</label>
      <input type="date" name="session_date" required><br>

      <label>Start klokken:</label>
      <input type="time" name="start_time" required><br>

      <label>Slutt klokken:</label>
      <input type="time" name="end_time" required><br>

      <label>Tema/Modul(er):</label>
      <input type="text" name="session_theme" required><br>

      <label>Lengde (i minutter):</label>
      <input type="number" name="length" required><br>

      <input type="submit" value="Set Time Slot">
   </form>
   <p><a href="../index.php">Tilbake til dashbord</a></p>
</body>

</html>