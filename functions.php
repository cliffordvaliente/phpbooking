<?php


function hidestatus()
{
   session_start();
   if (session_status() == PHP_SESSION_NONE) {
      session_start();
   }
}


?>