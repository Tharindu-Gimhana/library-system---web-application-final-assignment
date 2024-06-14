

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management System - Login</title>
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
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
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
        .error{
            color:red;
            text-align:center;
            margin:10px;
            border:1px solid red;
            padding:10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login Form</h2>
        <form action="login.back.php" method="post">
            <label for="Username">Username:</label>
            <input type="text" id="Username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="submit">Login</button>
            <?php
            if(isset($_GET["error"])){
                if($_GET["error"]=="invalid"){
                    echo ' <div class="error">Invalid password or username</div>';
                }elseif($_GET["error"]=="invalidaccess"){
                    echo ' <div class="error">Invalid access</div>';
                }
            }
            ?>
           
            <div class="form-footer">
                Not have account ? <a href="reg.php">sign up</a>
            </div>
        </form>
    </div>
</body>
</html>
