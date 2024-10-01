<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-container label {
            display: block;
            margin-bottom: 8px;
        }

        .login-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-container a {
            display: block;
            text-align: center;
            margin-top: 16px;
            color: #4caf50;
            text-decoration: none;
        }

        .dhwani {
            text-align: center;
            font-family: 'Pacifico', cursive;
            font-size: 70px;
        }
    </style>
</head>
<body>

<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'dhwani');

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = ""; // Initialize an empty message variable

    // Check if the username and password are provided
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $message = "Please enter both username and password.";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validate the login credentials
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Login successful, store user information in the session
            $user = $result->fetch_assoc();
            $_SESSION['username'] = $username;
            $_SESSION['fname'] = $user['fname'];
            $_SESSION['lname'] = $user['lname'];

            // Redirect to the home page
            header("Location: 01_home.php");
            exit();
        } else {
            $message = "Invalid username or password.";
        }

        $stmt->close();
    }

    // Display the message using JavaScript alert
    echo "<script type='text/javascript'>alert('$message');</script>";
}

$conn->close();
?>

    <div class="login-container">
        <a href="http://localhost/Project/01_home.php" class="dhwani">Dhwani</a>
        <h2>Login</h2>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">

            <button type="submit">Login</button>

            <a href="http://localhost/Project/03_register.php">Don't have an account? Register here.</a>
        </form>
    </div>

</body>
</html>