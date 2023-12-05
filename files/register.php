<?php
// Include necessary PHP files and functions
include_once '../files/functions.php';
hidestatus();

// Require database connection
require_once('../databases/db.php');

$errormessage = array();

// Below is the user registration. It checks against what is wrong and not against what is correct, by using $error.
 if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $password_repeat = trim($_POST["password_repeat"]);
    $selectedCourses = isset($_POST["courses"]) ? $_POST["courses"] : [];
    $courses = implode(', ', $selectedCourses);

    if (empty($full_name)) {
        $error[] = "Fullt navn må fylles ut";
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
    }
    if ($password !== $password_repeat) {
        $error[] = "Pass på at du gjentar passordet likt";
    }
    if (empty($error)) {
        include('../files/insert.php');
        header("Location: ../register_redirect.php"); // Redundant line, insert.php redirects
        exit();
    }

    // Here, each error is stored and then displayed on screen as a separate line.
    else {
        echo "Feil oppstod, vennligst rett på følgende:<br>";
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
        <label for="full_name">Fullt navn:</label>
        <input type="text" name="full_name" value="<?php echo isset($full_name) ? htmlspecialchars($full_name) : ''; ?>"><br>

        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"><br><br>
    
        <label>Fagkode:</label><br>
        <input type="checkbox" name="courses[]" value="2"> IS-115<br>
        <input type="checkbox" name="courses[]" value="1"> IS-116<br>

        <p>Passordet må være minst 8 tegn langt, inneholde <b>minst</b> én stor bokstav og ett tall. Vi anbefaler at du har noen små bokstaver også.</p>

        <label for="password">Passord:</label>
        <input type="password" name="password"><br>

        <label for="password_repeat">Gjenta Passord:</label>
        <input type="password" name="password_repeat"><br><br>

        <input type="submit" value="Registrer">
    </form>

</body>
</html>