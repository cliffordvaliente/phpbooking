<?php
$host = 'localhost';
//! NAME OF THE DATABASE
$db = 'phpbooking';
//! CREDENTIALS SQL USER
$user = 'root';
$pass = 'rootgit ';
$charset = 'utf8mb4';

//! PDO CONNECTION
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
   PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
   PDO::ATTR_EMULATE_PREPARES => false,
];

try {
   $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
   throw new \PDOException($e->getMessage(), (int) $e->getCode());
}



?>