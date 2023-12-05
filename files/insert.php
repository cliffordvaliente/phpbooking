<?php
require_once('../databases/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST["password"]);
    $selectedCourses = isset($_POST["courses"]) ? $_POST["courses"] : [];
    $additional_info = ''; // Assuming you have additional info for students

    if (!$email) {
        // Handle invalid email
        exit('Invalid email format');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo->beginTransaction();

        // Insert into Users
        $userSql = "INSERT INTO Users (full_name, email, password, role) VALUES (?, ?, ?, 'student')";
        $pdo->prepare($userSql)->execute([$full_name, $email, $hashed_password]);
        $user_id = $pdo->lastInsertId();

        // Insert into Students
        $studentSql = "INSERT INTO Students (user_id, additional_info) VALUES (?, ?)";
        $pdo->prepare($studentSql)->execute([$user_id, $additional_info]);

        // Insert into Student_Courses
        foreach ($selectedCourses as $course_id) {
            $courseSql = "INSERT INTO Student_Courses (student_id, course_id) VALUES (?, ?)";
            $pdo->prepare($courseSql)->execute([$user_id, $course_id]);
        }

        $pdo->commit();
        header("Location: register_redirect.php");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        // Handle and log error appropriately
        exit('Her gikk noe galt:' . $e->getMessage());
    }
}
?>