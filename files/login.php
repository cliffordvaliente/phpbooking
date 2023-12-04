<?php

//! INCLUDE PHP FILES HERE 
include_once 'functions.php';
hidestatus();

//! DB STUFF 
require_once('databases/db.php');

//! IF USER LOGGED IN -> REDIRECT TO DASHBOARD
if (isset($_SESSION['user_id'])) {
    header("Location: /dashboards/dstudent.php");
    exit();
}

//! STRING TO WRITE THE ERROR MESSAGE
$errormessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $stmt = $pdo->prepare("SELECT user_id, email, password, role FROM users WHERE email = ?");

    $stmt->execute([$email]);

    //! CHECK DB IF USER EXIST IN TABLE BEFORE FETCH DATA
    if ($stmt->rowCount() > 0) {

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        //! PASSWORD CHECK
        if (password_verify($password, $user['password'])) {


            //! SET SESSION VARIABLES WHEN SUCCESSFUL AND REDIRECT TO DASHBOARD
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            //header('Location: dashboard.inc.php');
            include('index.php');
            exit();
        } else {
            //! GET ERROR MESSAGE IF WRONG CREDENTIALS
            $errormessage = "Feil brukernavn eller passord.";
            error_log("Login Error: Incorrect email or password for $email", 0);
        }
    } else {
        //! ERROR MESSAGE IF EMAIL NOT FOUND IN TABLE DB
        $errormessage = "Feil brukernavn eller passord.";
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
    <h1>BOOKING APPLIKASJON</h1>
    <h2>Logg inn</h2>
    <form method="post" action="">
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
    <p>Ikke registrert ennå? <a href="files/register.php">Registrer deg her</a></p>
</body>

</html>