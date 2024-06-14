<?php
session_start(); // Start the session at the beginning

if (isset($_POST["submit"])) {
    $usernameOrEmail = $_POST["username"];
    $password = $_POST["password"];

    $servername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "library_system";

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM user WHERE (username = ? OR email = ?) AND password = ?");
    $stmt->bind_param("sss", $usernameOrEmail, $usernameOrEmail, $password);
    
    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["username"] = $row['username'];
        header("Location: bookreg.php");
        exit();
    } else {
        header("Location: login.php?error=invalid");
        exit();
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    header('Location: login.php?error=invalidaccess');
    exit();
}
?>
