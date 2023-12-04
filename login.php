<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
 }
require_once('db.php');
// include cookies
// Check if the user is already logged in
//session_start(); // SET COOKIES HERE

if (isset($_SESSION['user_id'])) {
    // User is already logged in, redirect to dashboard
    header("Location: dashboards/dstudent.php");
    exit();
}

$errormessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $stmt = $pdo->prepare("SELECT user_id, email, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);

    // Check if the user exists before attempting to fetch data
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Login successful, set session variables and redirect internally to dashboard include
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            //header('Location: dashboard.inc.php');
            include('dashboards/dstudent.php');
            exit();
        } else {
            $errormessage = "Feil brukernavn eller passord."; // Error message for wrong email or password
            error_log("Login Error: Incorrect email or password for $email", 0);
        }
    } else {
        $errormessage = "Feil brukernavn eller passord."; // Error message for account which doesnt exist, same text
        error_log("Login Error: Email not found for $email", 0);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logg inn</title>
</head>
<body>
    <h1>Bookingapplikasjon </h1>
    <h2>Logg inn</h2>
        <form method="post" action="index.php">
            <label for="email">E-post:</label>
            <input type="email" name="email" required>

            <br>

            <label for="password">Passord:</label>
            <input type="password" name="password" required>

            <br>

            <input type="submit" value="Logg inn">
        </form>

    <?php
    if (!empty($errormessage)) {
        echo "<p>$errormessage</p>";
    }
    ?>
    <p>Ikke registrert ennå? <a href="register.php">Registrer deg her</a></p>
</body>
</html>