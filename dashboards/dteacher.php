<?php
include_once __DIR__ . "/../files/functions.php";
hidestatus();

require_once __DIR__ . '/../databases/db.php';

// Check if the user is logged in and a TA, redirect to login page if not.
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Assistant') {
    header("Location: ../index.php");
    exit();
}

// Fetch user data from the database based on the user_id stored in the session.
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// If not a TA, continue rendering HTML content
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- AJAX STUFF HERE --------------------------------------------------------->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css' rel='stylesheet'
        media='print' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
    <!-- AJAX STUFF END --------------------------------------------------------->

    <title>Dashboard Assistant</title>
</head>

<body>
    <!-- NAVIGATION BAR ------------------------------------------------------------------>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01"
                aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarColor01">
                <ul class="navbar-nav me-auto ">
                    <li class="nav-item">
                        <a href="./index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a href="./bookings/bteacher.php">Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a href="./files/logout.php">Logg ut</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- NAVIGATION BAR END ----------------------------------------------------------------->

    <div>

        <h2>Velkommen til hjelpelærersiden av Bookingapplikasjonen,
            <?php echo $user['full_name']; ?>!
        </h2>
        <p>Ditt Profil informasjon</p>
        <ul>
            <li>Ditt navn:
                <?php echo $user['full_name']; ?>
            </li>
            <li>E-post:
                <?php echo $user['email']; ?>
            </li>
            <li><a href="./files/update_profile.php">Trykk her for å endre profilinformasjon</a></li>
        </ul>

    </div>
    <div id='calendar'></div>

    <script src="./files/script.js"></script> <!-- Custom JavaScript -->


</body>

</html>