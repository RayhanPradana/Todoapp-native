<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = trim($_POST['task_name']);
    $user_id = $_SESSION['user_id'];

    if (!empty($task_name)) {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, task_name) VALUES (?, ?)");
        $stmt->execute([$user_id, $task_name]);
    }
}

header("Location: index.php");
exit;
?>