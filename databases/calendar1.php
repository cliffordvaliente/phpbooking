<?php

require_once __DIR__ . '/../databases/db.php';

try {
   $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

   // Prepare and execute query
   $sql = "SELECT g.session_id, g.BookingStatus, c.course_name, u.full_name AS teacher_name 
            FROM Guidance_sessions g
            JOIN Users u ON g.assistant_id = u.user_id
            JOIN Courses c ON g.course_id = c.course_id";
   $stmt = $pdo->query($sql);

   $events = [];
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $events[] = [
         'title' => $row['course_name'] . ' - ' . $row['teacher_name'],
         'start' => $row['BookingStatus'], // Assuming BookingStatus holds the start date/time
         // Add other event properties if needed
      ];
   }

   // Return JSON
   echo json_encode($events);
} catch (PDOException $e) {
   // Handle error
   echo "Database error: " . $e->getMessage();
}
?>