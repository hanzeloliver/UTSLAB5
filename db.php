<?php
// Konfigurasi kredensial database
$host = 'localhost';
$db_name = 'todo_app';
$username = 'root'; // Ganti sesuai dengan kredensial MySQL Anda
$password = '';     // Ganti sesuai dengan kredensial MySQL Anda

try {
    // Membuat koneksi ke database dengan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    
    // Mengatur mode kesalahan menjadi exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Menampilkan pesan kesalahan jika koneksi gagal
    die("Connection failed: " . $e->getMessage());
}
?>
