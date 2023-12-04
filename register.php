<?php

//! INCLUDE PHP FILES HERE 
include_once 'functions.php';
hidestatus();

//! DB STUFF 
require_once('databases/db.php');
$errorMessages = [];

//! USER REGISTRATION STATEMENTS CONDITIONS
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //! FULL NAME
    $full_name = trim($_POST["full_name"]);
    //! EMAIL
    $email = trim($_POST["email"]);
    //! USERS PASSWORD
    $password = trim($_POST["password"]);
    $password_repeat = trim($_POST["password_repeat"]);
    //! COURSES
    $selectedCourses = isset($_POST["course_id"]) ? $_POST["courses"] : [];
    $courses = implode(', ', $selectedCourses);

    //! All the input must not be empty
    if (empty($full_name)) {
        $error[] = "Fult Navn må fylles ut";
    }
    if (empty($email)) {
        $error[] = "Email må fylles ut";
    }
    //! Check the format is EMAIL
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Emailformatet er ugyldig";
    }

    //! COURSES
    if (empty($selectedCourses)) {
        $error[] = "Husk å velge faget eller fagene dine!";
    }
    if (empty($password)) {
        $error[] = "Passordfeltet må fylles ut";
    }
    //! CHECK THE PASSWORD MEETS CRITERIA 8 length and special char
    elseif (strlen($password) < 8 || !preg_match('/[A-ZÆØÅ]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error[] = "Passordet må være minst 8 tegn langt, inneholde minst én stor bokstav og ett tall. Vi anbefaler at du har noen små bokstaver også.";
    } else {
        //! MAKE PASSWORD SECURED
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }
    if ($password !== $password_repeat) {
        //! PASSWORD CHECKER IS CORRECT WRITTEN
        $error[] = "Pass på at du gjentar passordet likt";
    }
    //! IF ALL STATEMENTS HAVE NO ERROR THIS LINE RUNS
  
      if (empty($errorMessages)) {
        include('insert.inc.php');
        //! REDIRECT TO INDEX
        header("Location: index.php?registered=1");
        exit();
    } else {
        foreach ($errorMessages as $message) {
            echo "<p>Error: $message</p>";
        }
    }
}

    //* Here, each ERROR is stored and then displayed on screen as a separate line.
    else {
        echo "Feil oppstod, vennligst trykk på tilbakeknappen og rett på følgende:<br>";
        foreach ($error as $errormessage) {
            echo "-$errormessage<br>";
        }
        ;
    }
}

?>

<!DOCTYPE html>
<html lang="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrer en bruker</title>
</head>

<body>

    <h3>Brukerregistrering</h3>
    <form method="POST" action="insert.inc.php" accept-charset="UTF-8">
        <label for="firstname">Fornavn:</label>
        <input type="text" name="full_name"
            value="<?php echo isset($full_name) ? htmlspecialchars($full_name) : ''; ?>"><br>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"><br><br>

        <label>Fagkode</label><br>
        <input type="checkbox" name="courses[]" value="2"> IS-115<br>
        <input type="checkbox" name="courses[]" value="1"> IS-116<br>


        <p>Passordet må være minst 8 tegn langt, inneholde <b>minst</b> én stor bokstav og ett tall. Vi anbefaler at du
            har noen små bokstaver også.</p>

        <label for="password">Passord:</label>
        <input type="password" name="password"><br>

        <label for="password_repeat">Gjenta Passord:</label>
        <input type="password" name="password_repeat"><br><br>

        <input type="submit" value="Registrer">
    </form>

</body>

</html>