<?php
include_once __DIR__ . "/../files/functions.php";
hidestatus();
redirectForbidden();

require_once __DIR__ . '/../databases/db.php';

/* SET_PREFERENCES.PHP
 * This code lets students set their preferred teaching assistant.
 * It fetches TAs in a drop-down list. Users choose their preferred TA and submit.
 * The database is updated in the 'users' table with the TAs chosen name.
*/

$user_id = $_SESSION['user_id'];

// Fetch user data from the database based on the user_id stored in the session.
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch a list of TAs from the database
$ta_stmt = $pdo->prepare("SELECT user_id, full_name FROM users WHERE role = 'Assistant'");
$ta_stmt->execute();
$ta_list = $ta_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission to set preferences
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve selected TA's user_id from the form
    $selected_ta_id = $_POST["preferences"];

    // Fetch the selected TA's first and last name
    $selected_ta_stmt = $pdo->prepare("SELECT full_name FROM users WHERE user_id = ?");
    $selected_ta_stmt->execute([$selected_ta_id]);
    $selected_ta = $selected_ta_stmt->fetch(PDO::FETCH_ASSOC);

    // Update user preferences in the database with TA's first and last name
    $stmt = $pdo->prepare("UPDATE users SET preferences=? WHERE user_id=?");
    $stmt->execute([$selected_ta['full_name'], $user_id]);
    header("Location: ../index.php"); // Sends user back to dashboard when update is submitted
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Preferences</title>
    <!-- Add your stylesheets or additional styles here -->
</head>

<body>
    <h2>Sett foretrukken TA</h2>

    <!-- HTML form for setting preferences -->
    <form method="post" action="">
        <label for="preferences">Foretrukken Lærerassistent:</label>
        <select name="preferences">
            <?php foreach ($ta_list as $ta): ?>
                <option value="<?php echo $ta['user_id']; ?>" <?php echo ($user['preferences'] == $ta['user_id']) ? 'selected' : ''; ?>>
                    <?php echo $ta['full_name']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <input type="submit" value="Lagre preferanser">
    </form>

    <p><a href="../index.php">Tilbake til dashbord</a></p>
</body>
</html>
