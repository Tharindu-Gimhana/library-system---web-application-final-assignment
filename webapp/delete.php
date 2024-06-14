<?php
session_start();

// Redirect user to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

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

if (isset($_GET['book'])) {
    $book = $_GET['book'];

    // Delete related records in fine table
    $delete_fine_query = $conn->prepare("DELETE FROM fine WHERE book_id = ?");
    $delete_fine_query->bind_param("s", $book);

    if ($delete_fine_query->execute()) {
        // Delete related records in bookborrower table
        $delete_related_records_query = $conn->prepare("DELETE FROM bookborrower WHERE book_id = ?");
        $delete_related_records_query->bind_param("s", $book);

        if ($delete_related_records_query->execute()) {
            // Prepare and bind the SQL delete query
            $query = $conn->prepare("DELETE FROM book WHERE book_id = ?");
            $query->bind_param("s", $book);

            // Execute the query
            if ($query->execute()) {
                // Redirect to bookreg.php with a success message
                header('Location: bookreg.php?deleted');
                exit; // Exit to prevent further execution
            } else {
                // Redirect to bookreg.php with an error message
                header('Location: bookreg.php?notdelete');
                exit; // Exit to prevent further execution
            }
        } else {
            // Redirect to bookreg.php with an error message
            header('Location: bookreg.php?notdelete');
            exit; // Exit to prevent further execution
        }
    } else {
        // Redirect to bookreg.php with an error message
        header('Location: bookreg.php?notdelete');
        exit; // Exit to prevent further execution
    }
}

$conn->close();
?>
