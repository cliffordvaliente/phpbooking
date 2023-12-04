<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
 }
require_once('db.inc.php');

// Check if the user is logged in, redirect to login page if not.
//session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data from the database based on the user_id stored in the session.
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$error = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $cellphone = trim($_POST["cellphone"]);
    $email = trim($_POST["email"]);

    if (empty($firstname)) {
        $error[] = "Fornavn må fylles ut";
    }
    if (empty($lastname)) {
        $error[] = "Etternavn må fylles ut";
    }
    if (empty($cellphone)) {
        $error[] = "Mobilnummer må fylles ut";
    } elseif (!preg_match('/^[49]/', $cellphone) || !is_numeric($cellphone) || strlen($cellphone) !== 8) {
        $error[] = "Mobilnummer må være et 8-sifret gyldig norsk mobilnummer.";
    }
    if (empty($email)) {
        $error[] = "Email må fylles ut";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Emailformatet er ugyldig";
    }

    if (empty($error)) {
        // Update user information in the database
        $stmt = $pdo->prepare("UPDATE users SET firstname=?, lastname=?, cell=?, email=? WHERE user_id=?");
        $stmt->execute([$firstname, $lastname, $cellphone, $email, $user_id]);
        header("Location: dashboard.inc.php"); // Sends user back when update is submitted
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
        <label for="firstname">Fornavn:</label>
        <input type="text" name="firstname" value="<?php echo isset($user['firstname']) ? $user['firstname'] : ''; ?>"><br>

        <label for="lastname">Etternavn:</label>
        <input type="text" name="lastname" value="<?php echo isset($user['lastname']) ? $user['lastname'] : ''; ?>"><br>

        <label for="cellphone">Mobilnummer:</label>
        <input type="text" name="cellphone" value="<?php echo isset($user['cell']) ? $user['cell'] : ''; ?>"><br>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>"><br><br>

        <input type="submit" value="Oppdater profil">

        <p><a href="dashboard.inc.php">Tilbake til dashbord</a></p>
    </form>
</body>
</html>
