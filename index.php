<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="stylesheet/style.css">
   <title>Home Page</title>
</head>

<body>

</body>

</html>

<?php
//! INCLUDE PHP FILES HERE 
include_once "files/functions.php";
hidestatus();

if (isset($_SESSION['user_id'])) {
   // User is logged in
   if (isset($_SESSION['role'])) {
       // Check user role
       if ($_SESSION['role'] == 'Student') {
           // User is a student, include student dashboard
           include('./dashboards/dstudent.php');
       } elseif ($_SESSION['role'] == 'Assistant') {
           // User is an assistant, include assistant dashboard
           include("./dashboards/dteacher.php");
       } else {
           // Unknown role, handle accordingly
           include('files/login.php');
       }
   } else {
       // Role is not set, handle accordingly
       include('files/login.php');
   }
} else {
   // User is not logged in, include login content
   include('files/login.php');
}
?>