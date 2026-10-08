<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Pastikan task milik user yang sedang login
    $stmt = $pdo->prepare("UPDATE tasks SET status = IF(status='pending', 'completed', 'pending') WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
}

header("Location: index.php");
exit;
?>