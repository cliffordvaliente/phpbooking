<?php
include_once "../files/functions.php";
hidestatus();

require_once('../databases/db.php');


// Check if the user is logged in, redirect to login page if not.
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Check the user's role and redirect TAs to their dashboard - THIS MAY BE DEPRECATED HEADER ISNT CORRECT HELLO LOOK AT ME!!!
if (isset($_SESSION['role']) && $_SESSION['role'] == 'TA') {
    header("Location: dashboard_ta.php");
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
    <title>Dashboard</title>
</head>

<body>
    <h2>Velkommen til Bookingapplikasjonen,
        <?php echo $user['firstname']; ?>!
    </h2>

    <p>Brukerinformasjon:</p>
    <ul>
        <li>Navn:
            <?php echo $user['firstname'] . ' ' . $user['lastname']; ?>
        </li>
        <li>Email:
            <?php echo $user['email']; ?>
        </li>
        <li><a href="../files/update_profile.php">Endre profilinformasjon</a></li>
        <li><a href="../files/set_preferences.php">Sett foretrukken Lærerassistent</a></li>

    </ul>

    <p><a href="../files/logout.php">Logg ut</a></p>
</body>

</html>