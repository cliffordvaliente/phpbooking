<?php
// Include necessary PHP files and functions
include_once '../files/functions.php';
hidestatus();

// Require database connection
require_once('../databases/db.php');

/* REGISTER.PHP
 * Below is the user registration. It checks against what is wrong and not against what is correct, by using $error.
 * The text next to the error variables explains why errors occur.
 * In the html form, there is som php code which 'remembers' user input, namely name and email in case the form is
 * submitted while wrong or incomplete.
*/

$errormessage = array();

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
        header("Location: ../register_redirect.php"); // Redundant line, insert.php redirects. Keep in just in case.
        exit();
    }

    // Here, each error is stored and then displayed on the same page as separate lines.
    else {
        echo "Feil oppstod, vennligst rett på følgende:<br>";
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
    <link rel="stylesheet" href="../stylesheet/style.css">
    <title>Registrer en bruker</title>
</head>

<body>

    <div class="body1">
        <div class="blur">
            <div class="loginbox">
                <div class="loginboxchild">
                    <h2>Registrer deg</h2>
                    <div id="boxcenter">
                        <form method="post" action="" accept-charset="UTF-8">
                            <div class="divinputs">

                                <label for="full_name">fullt navn</label>
                                <input type="text" name="full_name"
                                    value="<?php echo isset($full_name) ? htmlspecialchars($full_name) : ''; ?>"><br>
                            </div>
                            <div class="divinputs">

                                <label for="email">e-post</label>
                                <input type="text" name="email"
                                    value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"><br><br>
                            </div>
                            <div id="divinputs2">
                                <div>
                                    <label>fagkode</label>
                                </div><br><br>
                                <div>
                                    <div id="divinputs3">
                                        <p> IS-115</p>
                                        <input type="checkbox" id="checkbox" name="courses[]" value="2"> <br>
                                    </div>
                                    <div id="divinputs3">
                                        <p> IS-116</p>
                                        <input type="checkbox" id="checkbox" name="courses[]" value="1"> <br>
                                    </div>
                                </div>
                            </div>
                            <div class="divinputs">


                                <label for="password">Passord</label>
                                <input type="password" name="password"><br>
                            </div>
                            <div class="divinputs">
                                <label for="password_repeat">Gjenta Passord</label>
                                <input type="password" name="password_repeat"><br><br>

                            </div>
                            <div class="divinputs">
                                <input id="button" type="submit" value="Registrer">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>