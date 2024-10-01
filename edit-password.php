<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #2c3e50; /* Dark background color */
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .dhwani-link {
            margin-bottom: 20px;
        }

        .dhwani-link a {
            text-decoration: none;
            color: white;
            font-size: 36px; /* Adjusted font size */
            font-family: 'Pacifico', cursive;
        }

        .edit-password-container {
            text-align: left;
            margin-bottom: 20px;
        }

        .edit-password-container h1 {
            color: #ecf0f1; /* Adjusted text color */
        }

        .edit-password-form {
            margin-bottom: 20px;
        }

        .edit-password-form label {
            display: block;
            margin-bottom: 8px;
        }

        .edit-password-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .edit-password-form button {
            padding: 10px;
            background-color: #2980b9; /* Adjusted color */
            color: #ecf0f1; /* Adjusted text color */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-password-form button:hover {
            background-color: #1a5276; /* Darker button color on hover */
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

            // Check if the old password is correct
            $oldPassword = $_POST['oldpassword'];
            $newPassword = $_POST['newpassword'];

            $username = $_SESSION['username'];

            $check_password_query = "SELECT * FROM user WHERE username = '$username' AND password = '$oldPassword'";
            $result = mysqli_query($conn, $check_password_query);

            if (mysqli_num_rows($result) > 0) {
                // Old password is correct, update the password
                $update_password_query = "UPDATE user SET password = '$newPassword' WHERE username = '$username'";
                $update_result = mysqli_query($conn, $update_password_query);

                if ($update_result) {
                    $message = "Password changed successfully!";
                } else {
                    $message = "Failed to update password.";
                }
            } else {
                // Old password is incorrect
                $message = "Wrong password. Please enter the correct old password.";
            }

            // Display the message using JavaScript alert
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        $conn->close();
    ?>

    <div class="dhwani-link">
        <a href="http://localhost/Project/01_home.php">Dhwani</a>
    </div>

    <div class="edit-password-container">
        <h1>Edit Password</h1>

        <div class="edit-password-form">
            <form action="" method="post">
                <label for="oldpassword">Old Password:</label>
                <input type="password" id="oldpassword" name="oldpassword" placeholder="Enter your old password" required>

                <label for="newpassword">New Password:</label>
                <input type="password" id="newpassword" name="newpassword" placeholder="Enter your new password" required>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

</body>
</html>
