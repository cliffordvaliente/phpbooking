<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Index File</title>
</head>

<body>

</body>

</html>

<?php
// Include (require) files here, cookies config etc.

// Include the appropriate content based on the login status
session_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
 }

if (isset($_SESSION['user_id'])) {
    // User is logged in, include dashboard content
    include('dashboard.inc.php');
    //include('bookingtable.inc.php');
} else {
    // User is not logged in, include login content
    include('login.inc.php');
}

if (isset($_GET['logout'])) {
    echo 'Du er nå logget ut.';
}

if (isset($_GET['registered'])) {
    echo 'Profilen din er opprettet. Vennligst logg inn.';
}
?>