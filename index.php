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

//! Checks if user is logged in
if (isset($_SESSION['user_id'])) {
   // User is logged in, include dashboard content
   include('./dashboards/dstudent.php');
} else {
   // User is not logged in, include login content
   include('files/login.php');
}
?>