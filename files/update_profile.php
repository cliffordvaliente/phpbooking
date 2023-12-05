<?php
include_once __DIR__ . "/../files/functions.php";
hidestatus();
redirectForbidden();

require_once __DIR__ . '/../databases/db.php';

$user_id = $_SESSION['user_id'];

// Fetch user data from the database based on the user_id stored in the session.
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$error = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);

    if (empty($full_name)) {
        $error[] = "Navn må fylles ut";
    }
    if (empty($email)) {
        $error[] = "Email må fylles ut";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Emailformatet er ugyldig";
    }

    if (empty($error)) {
        // Update user information in the database
        $stmt = $pdo->prepare("UPDATE users SET full_name=?, email=? WHERE user_id=?");
        $stmt->execute([$full_name, $email, $user_id]);
        header("Location: ../index.php"); // Sends user back to dashboard when update is submitted
        exit();
        // Fetch updated user data
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Display errors if any
        echo "Feil oppstod, vennligst rett på følgende:<br>";
        foreach ($error as $errormessage) {
            echo "-$errormessage<br>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oppdater profil</title>
</head>
<body>
    <!-- HTML-form for updating user profile -->
    <h2>Oppdater profil</h2>
    <form method="post" action="" accept-charset="UTF-8">
        <label for="full_name">Fullt navn:</label>
        <input type="text" name="full_name" value="<?php echo isset($user['full_name']) ? $user['full_name'] : ''; ?>"><br>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>"><br><br>

        <input type="submit" value="Oppdater profil">

        <p><a href="../index.php">Tilbake til dashbord</a></p>
    </form>
</body>
</html>
