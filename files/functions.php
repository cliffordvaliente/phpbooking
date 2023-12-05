<?php

//! ALL FUNCTIONS FOR PHP FOR THE PROJECT

//! HIDE STATUS ABOUT SESSION
function hidestatus()
{
   if (session_status() == PHP_SESSION_NONE) {
      session_start();
   }
}

//! REDIRECTS TO FRONT PAGE IF NOT LOGGED IN
function redirectForbidden()
{
   if (!isset($_SESSION['user_id'])) {
      header("Location: index.php");
      exit();
  }
}

//! 

?>