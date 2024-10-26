<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>To-Do List Application</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif; /* Use a clean sans-serif font */
            background-color: #f4f4f4; /* Light gray background */
            color: #333; /* Dark gray text color */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            display: flex; /* Use flexbox for centering */
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            height: 100vh; /* Full viewport height */
        }

        /* Container for content */
        .container {
            text-align: center; /* Center text */
            background: #fff; /* White background for the container */
            padding: 20px; /* Padding inside the container */
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        /* Headings */
        h1 {
            color: #4CAF50; /* Green color for the heading */
            margin-bottom: 10px; /* Space below the heading */
        }

        /* Paragraphs */
        p {
            font-size: 16px; /* Font size for paragraphs */
            margin: 10px 0; /* Space above and below paragraphs */
        }

        /* Links */
        a {
            color: #4CAF50; /* Green color for links */
            text-decoration: none; /* Remove underline */
        }

        a:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the To-Do List Application</h1>
        <p>Please <a href="login.php">login</a> or <a href="register.php">register</a> to continue.</p>
    </div>
</body>
</html>
