<?php
session_start();
require 'db.php'; // Include the database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the email and password from the form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);

    // Fetch the user record
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        // Password is correct, set the session
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php"); // Redirect to dashboard
        exit();
    } else {
        // Invalid email or password
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Reset default margin dan padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body styling */
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #4CAF50, #333);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Container styling */
.container {
    background-color: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
}

/* Judul H1 styling */
h1 {
    text-align: center;
    color: #4CAF50;
    margin-bottom: 20px;
}

/* Input field styling */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s; /* Transisi warna border */
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: #4CAF50; /* Warna border saat fokus */
    outline: none; /* Menghilangkan outline default */
}

/* Button styling */
button[type="submit"] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease, transform 0.2s; /* Tambahkan transisi transform */
}

button[type="submit"]:hover {
    background-color: #3e8e41;
    transform: scale(1.05); /* Efek memperbesar saat hover */
}

/* Tautan pendaftaran styling */
.signup-link {
    text-align: center;
    margin-top: 15px;
    color: #666;
}

.signup-link a {
    color: #4CAF50;
    text-decoration: none;
}

.signup-link a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p> <!-- Display error message -->
        <?php endif; ?>
        <form method="POST" action="login.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p class="signup-link">Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>
