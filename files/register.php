<?php
// Include necessary PHP files and functions
include_once '../files/functions.php';
hidestatus();

// Require database connection
require_once('../databases/db.php');
$errorMessages = []; // Initialize an array to hold error messages

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and trim form data
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $password_repeat = trim($_POST["password_repeat"]);
    // Collect selected courses or initialize as empty array if none selected
    $selectedCourses = isset($_POST["courses"]) ? $_POST["courses"] : [];

    // Validate full name
    if (empty($full_name)) {
        $errorMessages[] = "Fullt Navn må fylles ut";
    }
    // Validate email and check format
    if (empty($email)) {
        $errorMessages[] = "Email må fylles ut";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessages[] = "Emailformatet er ugyldig";
    }

    // Validate course selection
    if (empty($selectedCourses)) {
        $errorMessages[] = "Husk å velge faget eller fagene dine!";
    }
    // Validate password
    if (empty($password)) {
        $errorMessages[] = "Passordfeltet må fylles ut";
    } elseif (strlen($password) < 8 || !preg_match('/[A-ZÆØÅ]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errorMessages[] = "Passordet må være minst 8 tegn langt, inneholde minst én stor bokstav og ett tall. Vi anbefaler at du har noen små bokstaver også.";
    }
    // Check if password and repeat password match
    if ($password !== $password_repeat) {
        $errorMessages[] = "Pass på at du gjentar passordet likt";
    }

    // If there are no errors, proceed to include the insert script and redirect
    if (empty($errorMessages)) {
        include('../files/insert.php');
        header("Location: ../index.php?registered=1");
        exit();
    }
}

// Display any error messages if they exist
if (!empty($errorMessages)) {
    foreach ($errorMessages as $message) {
        echo "<p>Error: $message</p>";
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
    <form method="POST" action="insert.php" accept-charset="UTF-8">
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