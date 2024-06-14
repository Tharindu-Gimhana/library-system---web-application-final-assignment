<?php
session_start();

// Redirect user to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'library_system');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'submit') {
        $category_id = $conn->real_escape_string(trim($_POST['category_id']));
        $category_Name = $conn->real_escape_string(trim($_POST['category_Name']));
        $date_modified = date('Y-m-d H:i:s');

        if (!preg_match('/^C\d{3}$/', $category_id)) {
            echo 'Invalid Category ID format. Use CXXX format.';
            exit;
        }

        $sql = "INSERT INTO bookcategory (category_id, category_Name, date_modified)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE
                category_Name=VALUES(category_Name), date_modified=VALUES(date_modified)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('sss', $category_id, $category_Name, $date_modified);
            if ($stmt->execute()) {
                echo 'Category submitted successfully';
            } else {
                echo 'Error: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            echo 'Error: ' . $conn->error;
        }
    }

    if ($action == 'delete') {
        $category_id = $conn->real_escape_string(trim($_POST['category_id']));

        $sql = "DELETE FROM bookcategory WHERE category_id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('s', $category_id);
            if ($stmt->execute()) {
                echo 'Category deleted successfully';
            } else {
                echo 'Error: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            echo 'Error: ' . $conn->error;
        }
    }

    $conn->close();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'fetch') {
    $sql = 'SELECT * FROM bookcategory';
    $result = $conn->query($sql);
    $categories = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        $result->free();
    } else {
        echo 'Error: ' . $conn->error;
    }

    echo json_encode($categories);
    $conn->close();
    exit;
}
?>
