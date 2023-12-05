<?php
include_once __DIR__ . "/../files/functions.php";
hidestatus();
redirectForbidden();

require_once __DIR__ . '/../databases/db.php';

/* UPDATE_PROFILE.PHP
 * This form works similarly to register.php. Here, already saved information is fetched
 * from the database and populated in the form fields. Users can change their information
 * and submit, at which point the database is updated.
 */
$user_id = $_SESSION['user_id'];

// Fetch user data from the database based on the user_id stored in the session.
$stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$errormessage = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $new_password = trim($_POST["new_password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if (empty($full_name)) {
        $error[] = "Navn må fylles ut";
    }
    if (empty($email)) {
        $error[] = "Email må fylles ut";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Ugyldig emailformat";
    }
    if (empty($new_password)) {
        $error[] = "Passordfeltet må fylles ut";
    } elseif (strlen($new_password) < 8 || !preg_match('/[A-ZÆØÅ]/', $new_password) || !preg_match('/[0-9]/', $new_password)) {
        $error[] = "Passordet må være minst 8 tegn langt, inneholde minst én stor bokstav og ett tall. Vi anbefaler at du har noen små bokstaver også.";
    }
    if ($new_password !== $confirm_password) {
        $error[] = "Pass på at du gjentar passordet likt";
    }
    if (empty($error)) {
        // Update user information in the database
        $updateFields = "full_name=?, email=?";
        $updateValues = array($full_name, $email);

        // Check if new password is provided and update the password field
        if (!empty($new_password)) {
            $updateFields .= ", password=?";
            $updateValues[] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $stmt = $pdo->prepare("UPDATE users SET $updateFields WHERE user_id=?");
        $updateValues[] = $user_id;

        $stmt->execute($updateValues);

        header("Location: ../index.php");
        exit();
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
        <input type="text" name="full_name"
            value="<?php echo isset($user['full_name']) ? $user['full_name'] : ''; ?>"><br>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>"><br>

        <label for="new_password">Nytt passord:</label>
        <input type="password" name="new_password"><br>

        <label for="confirm_password">Bekreft passord:</label>
        <input type="password" name="confirm_password"><br><br>

        <input type="submit" value="Oppdater profil">

        <p><a href="../index.php">Tilbake til dashbord</a></p>
    </form>
</body>

</html>