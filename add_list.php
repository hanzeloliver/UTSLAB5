<?php
session_start();
require 'db.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(403); // Forbidden
    echo json_encode(['message' => 'Unauthorized']);
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $title = trim($_POST['title']);
    
    if (empty($title)) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Title is required']);
        exit();
    }

    // Insert the new to-do list into the database
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("INSERT INTO todo_lists (user_id, title) VALUES (?, ?)");
    
    if ($stmt->execute([$user_id, $title])) {
        // Get the ID of the newly created list
        $list_id = $pdo->lastInsertId();
        http_response_code(201); // Created
        echo json_encode(['message' => 'To-Do List created successfully', 'list_id' => $list_id]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Failed to create To-Do List']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['message' => 'Method not allowed']);
}
?>