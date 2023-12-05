<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="stylesheet/style.css">
   <link rel="stylesheet" href="stylesheet/bootstrap.css">
   <title>Home Page</title>
</head>

<body>

</body>

</html>

<?php
//! INCLUDE PHP FILES HERE 
include_once "files/functions.php";
hidestatus();

/* INDEX.PHP
 * Index.php functions as the landing page, home page and login page all at once. Through a series of
 * if/elseif/else-statements along with various include-statements, it checks the login status of the
 * user and dynamically shows the page they are supposed to be on. If the user is not logged in, they
 * are shown the login page with a register link. If the user IS logged in, they are shown a dashboard
 * based on what their 'role' is set as.
*/
if (isset($_SESSION['user_id'])) {
   // If user is logged in
   if (isset($_SESSION['role'])) {
       // Check user role
       if ($_SESSION['role'] == 'Student') {
           // If user is a student, include student dashboard
           include('./dashboards/dstudent.php');
       } elseif ($_SESSION['role'] == 'Assistant') {
           // Else, if user is an assistant, include assistant dashboard
           include("./dashboards/dteacher.php");
       } else {
           // Unknown role, include login. Safety in case of unpredictable behavior
           include('files/login.php');
       }
   } else {
       // Role is not set, include login. Safety in case of unpredictable behavior
       include('files/login.php');
   }
} else {
   // Else, if user is not logged in, include login content
   include('files/login.php');
}
?>