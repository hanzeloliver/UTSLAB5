<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID daftar to-do dari query string
$list_id = $_GET['list_id'];

// Ambil tugas yang terkait dengan daftar to-do yang dipilih
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE list_id = ?");
$stmt->execute([$list_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ambil judul daftar to-do untuk ditampilkan di halaman
$stmt = $pdo->prepare("SELECT title FROM todo_lists WHERE id = ?");
$stmt->execute([$list_id]);
$list = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>View To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4; /* Latar belakang abu-abu muda */
            color: #333; /* Warna teks */
            display: flex;
            flex-direction: column;
            align-items: center; /* Pusatkan konten secara horizontal */
        }

        h1 {
            color: #2c3e50; /* Warna gelap untuk judul */
            margin-bottom: 20px; /* Ruang di bawah judul */
            text-align: center; /* Pusatkan teks */
        }

        ul {
            list-style-type: none; /* Hilangkan poin pada daftar */
            padding: 0; /* Hilangkan padding */
            width: 100%; /* Lebar penuh */
            max-width: 600px; /* Maksimal lebar untuk daftar */
        }

        li {
            margin: 10px 0; /* Ruang antara item daftar */
            padding: 10px;
            border: 1px solid #ddd; /* Border item */
            border-radius: 5px; /* Sudut membulat */
            background: #ffffff; /* Latar belakang putih untuk item */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Bayangan halus */
            transition: background 0.3s; /* Transisi halus untuk hover */
        }

        li:hover {
            background: #f0f0f0; /* Warna latar belakang saat hover */
        }

        a {
            display: inline-block;
            margin-top: 20px; /* Ruang di atas tautan */
            padding: 10px 15px; /* Padding untuk tautan */
            background: #3498db; /* Warna latar belakang tautan */
            color: white; /* Warna teks tautan */
            text-decoration: none; /* Hilangkan garis bawah */
            border-radius: 5px; /* Sudut membulat */
        }

        a:hover {
            background: #2980b9; /* Warna latar belakang tautan saat hover */
        }
    </style>
</head>
<body>
    <h1>Daftar Tugas untuk: <?= htmlspecialchars($list['title']) ?></h1>
    <ul>
        <?php if (empty($tasks)): ?>
            <li>Tidak ada tugas dalam daftar ini.</li>
        <?php else: ?>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <?= htmlspecialchars($task['task_name']) ?> - 
                    <?= $task['is_completed'] ? 'Selesai' : 'Belum Selesai' ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
