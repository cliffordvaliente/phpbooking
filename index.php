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
//! INCLUDE PHP FILES HERE 
include_once "files/functions.php";
hidestatus();

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
   echo 'You have been logged out.';
}
// 
if (isset($_SESSION['user_id'])) {
   // User is logged in, include dashboard content
   include('dashboards/dstudent.php');
} else {
   // User is not logged in, include login content
   include('files/login.php');
}



if (isset($_GET['registered'])) {
   echo 'Profilen din er opprettet. Vennligst logg inn.';
}
?>