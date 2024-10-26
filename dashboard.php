<?php 
session_start();
require 'db.php'; // Sertakan koneksi database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil username dari database
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

try {
    // Ambil daftar to-do yang ada untuk pengguna yang sudah login
    $stmt = $pdo->prepare("SELECT * FROM todo_lists WHERE user_id = ?"); 
    $stmt->execute([$user_id]);
    $todo_lists = $stmt->fetchAll(PDO::FETCH_ASSOC); 
} catch (Exception $e) {
    // Tangani potensi kesalahan
    die("Terjadi kesalahan saat mengambil daftar to-do: " . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS untuk meratakan elemen */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh; /* Tinggi viewport penuh */
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; /* Latar belakang abu-abu muda */
        }

        .header {
            width: 100%; /* Lebar penuh */
            background-color: black; /* Warna latar belakang hitam */
            color: white; /* Warna teks putih */
            display: flex;
            justify-content: space-between; /* Ruang antara elemen */
            align-items: center; /* Pusatkan vertikal */
            padding: 10px 20px; /* Padding */
            position: absolute; /* Posisi tetap */
            top: 0; /* Jarak dari atas */
        }

        .logout-button {
            background-color: #e74c3c; /* Latar belakang merah */
            color: white; /* Teks putih */
            border: none; /* Tanpa border */
            border-radius: 5px; /* Sudut membulat */
            padding: 10px 20px; /* Padding tombol */
            cursor: pointer; /* Kursor pointer saat hover */
        }

        .container {
            text-align: center; /* Pusatkan teks di dalam wadah */
            background: #fff; /* Latar belakang putih untuk wadah */
            padding: 20px; /* Padding di dalam wadah */
            border-radius: 8px; /* Sudut membulat */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Bayangan halus */
            margin-top: 60px; /* Ruang di bawah header */
        }

        form {
            margin-bottom: 20px; /* Ruang di bawah formulir */
        }

        ul {
            list-style-type: none; /* Hilangkan poin pada daftar */
            padding: 0; /* Hilangkan padding */
        }

        li {
            margin: 10px 0; /* Ruang antara item daftar */
        }

        a {
            margin-left: 10px; /* Ruang antara tautan */
        }
    </style>
</head>
<body>

<div class="header">
    <div class="username">Selamat datang, <?= htmlspecialchars($user['username']) ?></div>
    <form action="logout.php" method="POST">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</div>

<div class="container">
    <h1>Dashboard</h1>

    <!-- Form untuk menambah daftar to-do baru -->
    <form id="addListForm">
        <input type="text" name="list_title" id="list_title" placeholder="Daftar To-Do Baru" required>
        <button type="submit">Buat Daftar</button>
    </form>

    <!-- Tampilkan daftar to-do yang ada -->
    <ul id="todoLists">
        <?php if (!empty($todo_lists)): ?>
            <?php foreach ($todo_lists as $list): ?>
                <li>
                    <?= htmlspecialchars($list['title']) ?>
                    <a href="view_list.php?list_id=<?= htmlspecialchars($list['id']) ?>">Lihat</a>
                    <a href="delete_list.php?list_id=<?= htmlspecialchars($list['id']) ?>">Hapus</a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Tidak ada daftar to-do yang tersedia.</li>
        <?php endif; ?>
    </ul>
</div>

<script>
document.getElementById('addListForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Cegah pengiriman formulir yang default

    const title = document.getElementById('list_title').value;

    fetch('add_list.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'title': title,
        }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Respon jaringan tidak ok');
        }
        return response.json(); // Kembalikan data sebagai JSON
    })
    .then(data => {
        if (data.list_id) {
            const todoLists = document.getElementById('todoLists');
            const newListItem = document.createElement('li');
            newListItem.textContent = title; // Gunakan judul daftar baru

            const viewLink = document.createElement('a');
            viewLink.href = `view_list.php?list_id=${data.list_id}`;
            viewLink.textContent = 'Lihat';
            newListItem.appendChild(viewLink);

            const deleteLink = document.createElement('a');
            deleteLink.href = `delete_list.php?list_id=${data.list_id}`;
            deleteLink.textContent = 'Hapus';
            newListItem.appendChild(deleteLink);

            todoLists.appendChild(newListItem);
            document.getElementById('list_title').value = ''; // Kosongkan bidang input
        } else if (data.message) {
            alert(data.message); // Tampilkan pesan jika ada
        }
    })
    .catch(error => {
        console.error('Kesalahan:', error);
    });
});
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
