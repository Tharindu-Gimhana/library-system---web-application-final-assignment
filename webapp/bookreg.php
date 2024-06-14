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
}else{

    $book_list = '';
    $search = '';

	// getting the list of book
	if ( isset($_GET['search']) ) {
		$search = mysqli_real_escape_string($conn, $_GET['search']);
		$query = "SELECT book.*, bookcategory.category_Name
        FROM book
        INNER JOIN bookcategory ON book.category_id = bookcategory.category_id
        WHERE (book.book_id LIKE '%{$search}%' OR book.book_name LIKE '%{$search}%' OR bookcategory.category_Name LIKE '%{$search}%') ORDER BY book.book_id";					
	}else{
        // Getting the list of book
        $query = "SELECT book.*,bookcategory.category_Name FROM book INNER JOIN bookcategory ON book.category_id = bookcategory.category_id ORDER BY book_id";
    }
    $books = $conn->query($query);

    if ($books) {
        while ($book = $books->fetch_assoc()) {
            $book_list .= "<tr>";
            $book_list .= "<td>{$book['book_id']}</td>";
            $book_list .= "<td>{$book['book_name']}</td>";
            $book_list .= "<td>{$book['category_Name']}</td>";
            $book_list .= "<td><a href=\"edit.php?book={$book['book_id']}\">Edit</a></td>";
			$book_list .= "<td><a href=\"delete.php?book={$book['book_id']}\" onclick=\"return confirm('Are your sure?');\">Delete</a></td>";
            $book_list .= "</tr>";
        }
    } else {
        echo "Database query failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Record</title>
    <link rel="stylesheet" href="css\bootstrap.css">  
</head>
<body>
    <nav class="navbar navbar-dark navbar-expand-sm" style="background-color: blueviolet;">
        <div class="container-fluid">
            <h1 class="navbar-brand">Library</h1>
            <button class="navbar-toggler"  data-toggle="collapse" data-target="#dropdown" >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="dropdown">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="bookreg.php" class="nav-link active">Book Record</a></li>
                    <li class="nav-item"><a href="new form 2.php" class="nav-link">Add Book</a></li>
                    <li class="nav-item"><a href="category.php" class="nav-link">Book Category</a></li>
                </ul>
                <ul class="navbar-nav" >
                    <li class="nav-item">
                    <a href="logout.php" class="btn btn-danger nav-link " onclick="return confirm('Are your sure?');">Logout</a>
                    </li>
                </ul>
            </div>        
        </div>
    </nav>
    <!-- Bootstrap and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <div class="container-fluid mt-2">
            <form action="bookreg.php" method="get">
                <input type="text" name="search" placeholder="search book" class="w-50" required>
                <input type="submit" name="submit" value="search" class="btn btn-primary">
            </form>      
    </div>
    <table class="table table-striped table-hover">
        <tr>
            <th>BOOK ID</th>
            <th>BOOK NAME</th>
            <th>BOOK CATAGEORY</th>
            <th>EDIT</th>
            <th>DELETE</th>
        </tr>

        <?php echo $book_list; ?>
    </table>
    


</body>
</html>
