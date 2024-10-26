<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$list_id = $_GET['list_id'];

$stmt = $pdo->prepare("DELETE FROM todo_lists WHERE id = ?");
$stmt->execute([$list_id]);

header("Location: dashboard.php");
?>