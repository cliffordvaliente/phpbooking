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
    <link rel="stylesheet" href="./stylesheet/dteacher.css">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Assistant</title>
</head>

<body>

    <nav>

        <ul>
            <li>
                <a href="./index.php">Dashboard</a>
            </li>
            <li>
                <a href="./bookings/bteacher.php">Bookings</a>
            </li>
            <li>
                <a href="./files/logout.php">Logg ut</a>
            </li>
        </ul>

    </nav>


    <div id="xx">

        <h2>Velkommen LA.
            <?php echo $user['full_name']; ?>!
            Her er ditt Booking Dashboard
        </h2>
        <h3>Ditt Profil informasjon</h3>
        <ul>
            <li>Ditt navn:
                <?php echo $user['full_name']; ?>
            </li>
            <li>E-post:
                <?php echo $user['email']; ?>
            </li>
            <li><a href="./files/update_profile.php">Endre ditt profil her</a></li>
        </ul>

    
    <div><?php include('./bookings/display_bteacher.php');?></div>
    </div>
</body>
</html>