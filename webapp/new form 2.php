<?php
session_start();

// Redirect user to login page if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library_system";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);}

if (isset($_POST['submit'])) {
    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
	$category_id = $_POST['category_id'];
	$query = mysqli_query($conn,("INSERT INTO Book(book_id,book_name,category_id) VALUES ('$book_id', '$book_name','$category_id')"));
    if ($query) {
        echo "<script>alert('RECORD CREATED SUCCESFULLY')</script>";
    } else {
        echo "<script>alert('ERROR')</script>";
    }
}	
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dropdown</title>
    <link rel="stylesheet" href="css\bootstrap.css">  
	
	<style>
        body{
            background-color:cyan;
            
        }
        .bg {
            font-family: Arial, sans-serif;
            margin: 5%;
            padding: 0;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            width: 100%;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
		button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
			width:20%;
			font-size:25px;
        }
		
		.mode{
			width:50%;
			padding:8px ;
			border-radius:5px;
			background-color:white;
			border-color:blue;
			border-width:4px;
			font-size:25px;
		}
		
		.mode1{
			width:30%;
			padding:8px ;
			border-radius:5px;
			background-color:gray;
			border-color:white;
			border-width:4px;
			font-size:25px;
		}
		
		.error{
			color:red;
		}
		</style>
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
                    <li class="nav-item"><a href="bookreg.php" class="nav-link ">Book Record</a></li>
                    <li class="nav-item"><a href="new form 2.php" class="nav-link active">Add Book</a></li>
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

    <div class="bg">

	<h1 style="color:black;text-align:center;font-size:50px;">REGISTER BOOKS</h1>
    <form method="POST" >
        <label style="font-size:25px;color:purple;" for="book_id">Book ID:</label></br>
                <input class="mode" type="text" id="book_id" name="book_id" pattern="B\d+" required></BR>
                <small class="error">NOTE! Book ID must be in the format 'B<number>' (e.g., B123).</small><br />
				
		</BR><label style="font-size:25px;color:purple;">Book Name:   </label></br>
                <input class="mode" type="text" name="book_name" /><br />
				
		</BR><label style="font-size:25px;color:purple;">Category id:   </label></BR>
        <select class="mode1" name="category_id">
            <?php
            // Fetches all categories from the 'book_category' table
            $categories = mysqli_query($conn, "SELECT * FROM bookcategory");
            while ($c = mysqli_fetch_array($categories)) {
            ?>
                <!-- Creates an option for each category -->
                <option value="<?php echo $c['category_id'] ?>"><?php echo $c['category_Name'] ?><//option>
            <?php
            }
            ?>
        </select><br />
        </BR>
		</BR><button type="submit" name="submit">Submit</button>
    </form>
    </div>
</body>
</html>
