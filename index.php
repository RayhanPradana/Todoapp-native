<?php
require_once 'config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$user_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Todo App</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 500px; background: #fff; margin: 20px auto; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        .header h3 { margin: 0; color: #333; }
        .btn-logout { background: #dc3545; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .btn-logout:hover { background: #c82333; }
        form { display: flex; gap: 10px; margin-bottom: 20px; }
        input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        ul { list-style: none; padding: 0; }
        li { display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #eee; }
        li.completed span { text-decoration: line-through; color: #888; }
        .actions a { text-decoration: none; margin-left: 10px; font-size: 14px; }
        .btn-toggle { color: #28a745; }
        .btn-delete { color: #dc3545; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h3>Halo, <?= htmlspecialchars($_SESSION['username']) ?>!</h3>
        <a href="auth/logout.php" class="btn-logout">Logout</a>
    </div>
    
    <!-- Form Tambah Tugas -->
    <form method="POST" action="add.php">
        <input type="text" name="task_name" placeholder="Tulis rencana tugas baru..." required autocomplete="off">
        <button type="submit">Tambah</button>
    </form>

    <!-- Daftar Tugas -->
    <ul>
        <?php if (empty($tasks)): ?>
            <p style="text-align: center; color: #777;">Belum ada tugas.</p>
        <?php else: ?>
            <?php foreach ($tasks as $task): ?>
                <li class="<?= $task['status'] === 'completed' ? 'completed' : '' ?>">
                    <span><?= htmlspecialchars($task['task_name']) ?></span>
                    <div class="actions">
                        <a href="update.php?id=<?= $task['id'] ?>" class="btn-toggle">
                            <?= $task['status'] === 'completed' ? 'Batal' : 'Selesai' ?>
                        </a>
                        <a href="delete.php?id=<?= $task['id'] ?>" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>

</body>
</html>