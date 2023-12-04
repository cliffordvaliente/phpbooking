<?php
require_once('databases/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["full_name"]);
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST["password"]);
    $selectedCourses = isset($_POST["courses"]) ? $_POST["courses"] : [];

    if (!$email) {
        // Handle invalid email
        exit('Invalid email format');
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo->beginTransaction();

        $userSql = "INSERT INTO Users (full_name, email, password, role) VALUES (?, ?, ?, 'student')";
        $pdo->prepare($userSql)->execute([$full_name, $email, $hashed_password]);
        $user_id = $pdo->lastInsertId();

        foreach ($selectedCourses as $course_id) {
            $courseSql = "INSERT INTO Student_Courses (student_id, course_id) VALUES (?, ?)";
            $pdo->prepare($courseSql)->execute([$user_id, $course_id]);
        }

        $pdo->commit();
        header("Location: index.php?registered=1");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        // Handle and log error appropriately
        exit('An error occurred: ' . $e->getMessage());
    }
}
?>