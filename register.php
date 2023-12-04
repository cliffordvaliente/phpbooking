<?php

require_once('db.php');

/* This is the registration code*/

 $errormessage = array();

// Below is the user registration. It checks against what is wrong and not against what is correct, by using $error.
 if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $cellphone = trim($_POST["cellphone"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $password_repeat = trim($_POST["password_repeat"]);
    $selectedCourses = isset($_POST["courses"]) ? $_POST["courses"] : [];
    $courses = implode(', ', $selectedCourses);

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
    if (empty($selectedCourses)) {
        $error[] = "Husk å velge faget eller fagene dine!";
    }
    if (empty($password)) {
        $error[] = "Passordfeltet må fylles ut";
    } elseif (strlen($password) < 8 || !preg_match('/[A-ZÆØÅ]/', $password) || !preg_match('/[0-9]/', $password)) {
        $error[] = "Passordet må være minst 8 tegn langt, inneholde minst én stor bokstav og ett tall. Vi anbefaler at du har noen små bokstaver også.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }
    if ($password !== $password_repeat) {
        $error[] = "Pass på at du gjentar passordet likt";
    }
    if (empty($error)) {
        include('insert.inc.php');
        // Redirect to index.php after successful registration
        header("Location: index.php?registered=1");
        exit(); // No further code runs after this one runs
    }

    // Here, each error is stored and then displayed on screen as a separate line.
    else {
        echo "Feil oppstod, vennligst trykk på tilbakeknappen og rett på følgende:<br>";
        foreach ($error as $errormessage) {
            echo "-$errormessage<br>";
        };
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
    <!-- HTML-form for user registration -->
    <h2>Brukerregistrering</h2>
    <form method="post" action="" accept-charset="UTF-8">
        <label for="firstname">Fornavn:</label>
        <input type="text" name="firstname" value="<?php echo isset($firstname) ? htmlspecialchars($firstname) : ''; ?>"><br>

        <label for="lastname">Etternavn:</label>
        <input type="text" name="lastname" value="<?php echo isset($lastname) ? htmlspecialchars($lastname) : ''; ?>"><br>

        <label for="cellphone">Mobilnummer:</label>
        <input type="text" name="cellphone" value="<?php echo isset($cellphone) ? htmlspecialchars($cellphone) : ''; ?>"><br>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"><br><br>
    
        <label>Fagkode:</label><br>
        <input type="checkbox" name="courses[]" value="IS-116"> IS-116<br>
        <input type="checkbox" name="courses[]" value="IS-115"> IS-115<br>
        <input type="checkbox" name="courses[]" value="ORG-128"> ORG-128<br><br>

        <p>Passordet må være minst 8 tegn langt, inneholde <b>minst</b> én stor bokstav og ett tall. Vi anbefaler at du har noen små bokstaver også.</p>

        <label for="password">Passord:</label>
        <input type="password" name="password"><br>

        <label for="password_repeat">Gjenta Passord:</label>
        <input type="password" name="password_repeat"><br><br>

        <input type="submit" value="Registrer">
    </form>

</body>
</html>