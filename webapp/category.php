<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Category Management</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/bootstrap.css">
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
                    <li class="nav-item"><a href="new form 2.php" class="nav-link">Add Book</a></li>
                    <li class="nav-item"><a href="category.php" class="nav-link active" >Book Category</a></li>
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


<div class="form-container">
    <br>
    <h2>Register / Update Book Category</h2>
    <form id="categoryForm" action="book_category.php" method="post">
        <input type="text" id="categoryID" placeholder="Category ID (CXXX)" required>
        <input type="text" id="categoryName" placeholder="Category Name" required>
        <button type="button" onclick="submitCategory()">Submit</button>
    </form>
</div>

<table id="categoryTable">
    <thead>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Date Modified</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <!-- Rows will be populated by JavaScript -->
    </tbody>
</table>

<script src="script.js"></script>

</body>
</html>
