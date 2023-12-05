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

//! DELETES EXPIRED BOOKINGS
function cleanupExpiredBookings($pdo) {
   // Get the current date and time
   $currentDateTime = date('Y-m-d H:i:s');

   // Delete expired bookings
   $deleteQuery = "DELETE FROM guidance_sessions WHERE BookingStatus = 'Confirmed' AND bookingdate < ?";
   $stmt = $pdo->prepare($deleteQuery);
   $stmt->execute([$currentDateTime]);
}
?>