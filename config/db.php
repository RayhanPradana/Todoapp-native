<?php
$host = 'localhost';
$dbname = 'db_todo_app';
$username = 'root'; // Sesuaikan username database Anda
$password = ''; // Sesuaikan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>