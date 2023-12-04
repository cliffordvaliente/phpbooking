<?php
require_once('db.php');

$role = 'student'; // Set default role as student, TAs have to be manually modified to 'TA' in the database.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fornavn = trim($_POST["firstname"]); // Match the form field names
    $etternavn = trim($_POST["lastname"]);
    $mobilnummer = trim($_POST["cellphone"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $selectedCourses = isset($_POST["courses"]) ? $_POST["courses"] : [];


            $pdo->beginTransaction();

            // Insert into 'users' table
            $userSql = "INSERT INTO users
                (firstname, lastname, cell, email, password, role) 
                VALUES 
                (:firstname, :lastname, :cell, :email, :password, :role)";

            $userQuery = $pdo->prepare($userSql);

            $userQuery->bindParam(':firstname', $fornavn, PDO::PARAM_STR);
            $userQuery->bindParam(':lastname', $etternavn, PDO::PARAM_STR);
            $userQuery->bindParam(':cell', $mobilnummer, PDO::PARAM_STR);
            $userQuery->bindParam(':email', $email, PDO::PARAM_STR);
            $userQuery->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $userQuery->bindParam(':role', $role, PDO::PARAM_STR);

            $userQuery->execute();

            // Get the user_id of the inserted user
            $user_id = $pdo->lastInsertId();

            // Insert into 'courseid' table, backticks to identify correct columns in 'courseid' table
            $courseSql = "INSERT INTO courseid 
            (user_id, `IS-116`, `IS-115`, `ORG-128`)
            VALUES
            (:user_id, :is_116, :is_115, :org_128)";

            $courseQuery = $pdo->prepare($courseSql);

            // Set default values for courses
            $is_116 = 0;
            $is_115 = 0;
            $org_128 = 0;

            // Update the corresponding course column if it's selected
            if (in_array('IS-116', $selectedCourses)) {
                $is_116 = 1;
            }

            if (in_array('IS-115', $selectedCourses)) {
                $is_115 = 1;
            }

            if (in_array('ORG-128', $selectedCourses)) {
                $org_128 = 1;
            }

            $courseQuery->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $courseQuery->bindParam(':is_116', $is_116, PDO::PARAM_INT);
            $courseQuery->bindParam(':is_115', $is_115, PDO::PARAM_INT);
            $courseQuery->bindParam(':org_128', $org_128, PDO::PARAM_INT);

            $courseQuery->execute();

            $pdo->commit();

            // Check if registration was successful and handle it accordingly
            echo "Brukeren din er registrert! Velkommen, $fornavn";

            /* This code contains error messages, unsure if we should have this in on an active app
            if ($courseQuery->rowCount() > 0) {
                $pdo->commit();
                // Registration was successful
                echo "Brukeren din er registrert! Velkommen, $fornavn";
                // redirect here to login
            } else {
                $pdo->rollBack();
                echo "Error inserting into courseid table.";
            }
        } else {
            $pdo->rollBack();
            echo "Error inserting into users table.";
        } */
}
?>