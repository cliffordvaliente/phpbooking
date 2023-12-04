<?php

//! ALL FUNCTIONS FOR PHP FOR THE PROJECT

//! HIDE STATUS ABOUT SESSION
function hidestatus()
{
   session_start();
   if (session_status() == PHP_SESSION_NONE) {
      session_start();
   }
}
//! ------------------------------------------------

//! 

?>