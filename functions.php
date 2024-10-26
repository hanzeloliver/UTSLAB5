<?php
$host = 'localhost';
$db = 'todo_app';
$user = 'root'; // Sesuaikan jika diperlukan
$pass = ''; // Sesuaikan jika diperlukan

// Koneksi ke database menggunakan MySQLi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set karakter encoding untuk koneksi
mysqli_set_charset($conn, "utf8");
?>

