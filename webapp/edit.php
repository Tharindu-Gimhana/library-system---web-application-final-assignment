<?php
session_start();
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

$book_id = '';
$book_name = '';
$category_id = '';

if (isset($_GET['book'])) {
    $bookid = $_GET['book'];

    // Use a prepared statement to safely query the book information
    $query2 = "SELECT * FROM book WHERE book_id = ? LIMIT 1";
    if ($stmt = $conn->prepare($query2)) {
        $stmt->bind_param("s", $bookid);
        $stmt->execute();
        $result_set2 = $stmt->get_result();
        if ($result_set2 && $result_set2->num_rows == 1) {
            $result = $result_set2->fetch_assoc();
            $book_id = $result['book_id'];
            $book_name = $result['book_name'];
            $category_id = $result['category_id'];
        } else {
            header('Location: bookreg.php?error=book_not_found');
            exit;
        }
        $stmt->close();
    }
}

// Fetch book categories using a prepared statement
$query = "SELECT category_id, category_Name FROM bookcategory ORDER BY category_id";
$result_set = $conn->query($query);
$category_list = '';
while ($result = $result_set->fetch_assoc()) {
    $selected = ($result['category_id'] == $category_id) ? 'selected' : '';
    $category_list .= "<option value=\"{$result['category_id']}\" $selected>{$result['category_Name']}</option>";
}

if (isset($_POST['submit'])) {
    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
    $category_id = $_POST['category_id'];
    $original_book_id = $_GET['book'];

    // Begin transaction
    $conn->begin_transaction();

    try {
         // Update the fine table
         $update_fine = $conn->prepare("UPDATE fine SET book_id = ? WHERE book_id = ? LIMIT 1");
         $update_fine->bind_param("ss", $book_id, $original_book_id);
         $update_fine->execute();

        // Update the book table first
        $query = $conn->prepare("UPDATE book SET book_id = ?, book_name = ?, category_id = ? WHERE book_id = ? LIMIT 1");
        $query->bind_param("ssss", $book_id, $book_name, $category_id, $original_book_id);
        $query->execute();

        // Commit transaction
        $conn->commit();

        // Redirect to bookreg.php with a success message
        header('Location: bookreg.php?updated');
        exit; // Exit to prevent further execution
    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        // Redirect to bookreg.php with an error message
        header('Location: bookreg.php?erro=not_updated');
        exit; // Exit to prevent further execution
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Record</title>
    <link rel="stylesheet" href="css/bootstrap.css">  
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-sm" style="background-color: blueviolet;">
        <div class="container-fluid">
            <h1 class="navbar-brand">Library</h1>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#dropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="dropdown">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="bookreg.php" class="nav-link active">Book Record</a></li>
                    <li class="nav-item"><a href="new form 2.php" class="nav-link">Add Book</a></li>
                    <li class="nav-item"><a href="category.php" class="nav-link">Book Category</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="#" class="btn btn-danger nav-link" onclick="return confirm('Are you sure?');">Logout</a>
                    </li>
                </ul>
            </div>        
        </div>
    </nav>
    <div class="container mt-5">
        <form action="edit.php?book=<?php echo htmlspecialchars($book_id); ?>" method="post">
            <div class="form-group">
                <label>BOOK ID</label>
                <input type="text" name="book_id" class="form-control w-50" placeholder="Enter book id" value="<?php echo htmlspecialchars($book_id); ?>" pattern="B\d+" required>
                <small class="error">NOTE! Book ID must be in the format 'B<number>' (e.g., B123).</small>
            </div>
            <div class="form-group mt-2">
                <label>BOOK NAME</label>
                <input type="text" name="book_name" class="form-control w-50" placeholder="Enter book name" value="<?php echo htmlspecialchars($book_name); ?>" required>
            </div>
            <div class="form-group mt-2">
                <label>BOOK CATEGORY</label>
                <select name="category_id" id="category" class="form-control w-50">
                    <?php echo $category_list; ?>    
                </select>    
            </div>
            <button type="submit" name="submit" class="btn btn-primary mt-2">Update</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
