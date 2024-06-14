<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "library_system"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = array();
$first_name = '';
$last_name = '';
$email = '';
$password = '';
$username = '';
$userid = '';

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $query = "SELECT * FROM user WHERE email = '{$email}' LIMIT 1";

    $result_set = mysqli_query($conn, $query);

    if ($result_set && mysqli_num_rows($result_set) == 1) {
        $errors[] = 'Email address already exists';
    }

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $query = "SELECT * FROM user WHERE username = '{$username}' LIMIT 1";

    $result_set = mysqli_query($conn, $query);

    if ($result_set && mysqli_num_rows($result_set) == 1) {
        $errors[] = 'Username already exists';
    }

    $first_name = mysqli_real_escape_string($conn, $_POST['firstname']);
    $last_name = mysqli_real_escape_string($conn, $_POST['lastname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $userid = mysqli_real_escape_string($conn, $_POST['userid']);

    if (empty($errors)) {
        $query = "INSERT INTO user (user_id, email, first_name, last_name, username, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $userid, $email, $first_name, $last_name, $username, $password);

        if ($stmt->execute()) {
            // Query successful... redirecting to login page
            header('Location: login.php?user_added=true');
        } else {
            $errors[] = 'Failed to add the new record.';
        }

        $stmt->close();
    }
}

$conn->close();

function display_errors($errors) {
    echo '<div class="error-messages">';
    foreach ($errors as $error) {
        echo '<p>' . htmlspecialchars($error) . '</p>';
    }
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            box-sizing: border-box;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        input[type="submit"], button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #0056b3;
        }
        .form-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }
        .form-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .form-footer a:hover {
            text-decoration: underline;
        }
        .error-messages {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Library Management System - Registration</h2>
        <?php 
            if (!empty($errors)) {
                display_errors($errors);
            }
        ?>
        <form action="reg.php" method="post">
            <label for="userid">User ID:</label>
            <input type="text" id="userid" name="userid" pattern="U\d+" required>
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" required>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$" title="Password must contain at least one number, one uppercase and lowercase letter, one special character, and be at least 8 characters long" required>
            <button type="submit" name="submit">Register</button>
        </form>
        <div class="form-footer">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>
