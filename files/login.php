<?php

//! INCLUDE PHP FILES HERE 
include_once 'functions.php';
hidestatus();

//! DB STUFF 
require_once('./databases/db.php');

//! IF USER LOGGED IN -> REDIRECT TO DASHBOARD
if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboards/dstudent.php");
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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins&family=Ubuntu+Mono&display=swap');
    </style>
    <title>Logg inn</title>
</head>

<body>
    <div class="body1">
        <div class="blur">
            <div class="loginbox">
                <h1>Student Booking App</h1>
                <h3>logg inn</h3>
                <div id="boxcenter">
                    <form method="post" action="" class="formlogin">

                        <div class="divinputs">
                            <label for="email">e-post</label>
                            <input type="email" name="email" required>
                        </div>
                        <br>
                </div>

                <div class="divinputs">
                    <span class="label">passord</span>
                    <input type="password" name="password" class="password" required>
                    <br>
                </div>
                <div class="divinputs">
                    <input id="button" type="submit" value="Logg inn">

                </div>
                </form>
                <?php
                if (!empty($errormessage)) {
                    echo "<script>alert($errormessage)</script>";
                }
                ?>
                <p>Ikke registrert ennå? <a href="./files/register.php">Registrer deg her</a></p>
            </div>



        </div>
    </div>
    </div>
</body>

</html>