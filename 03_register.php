<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            height: 120vh;
            background-color: #f2f2f2;
        }

        .register-container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 550px; /* Adjusted width */
        }

        .register-container h1 {
            font-family: 'Pacifico', cursive;
            color: #333;
        }

        .register-container label {
            display: block;
            margin: 5px 0 8px;
            text-align: left;
        }

        .register-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <?php
        $conn = new mysqli('localhost', 'root', '', 'dhwani');

        if (!$conn) {
            die("Connection Failed: " . mysqli_connect_error());
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $alldata = true;
            $message = ""; // Initialize an empty message variable

            // Check if the first name is empty
            if (empty($_POST["firstname"])) {
                $message = "Missing First Name!";
                $alldata = false;
            }

            // Check if the last name is empty
            elseif (empty($_POST["lastname"])) {
                $message = "Missing Last Name!";
                $alldata = false;
            }

            // Check if the username is empty
            elseif (empty($_POST["username"])) {
                $message = "Missing Username!";
                $alldata = false;
            }

            // Check if the email is empty
            elseif (empty($_POST["email"])) {
                $message = "Missing Email!";
                $alldata = false;
            }

            // Check if the password is empty
            elseif (empty($_POST["password"])) {
                $message = "Missing Password!";
                $alldata = false;
            }

            // Check if the date of birth is empty
            elseif (empty($_POST["dob"])) {
                $message = "Missing Date of Birth!";
                $alldata = false;
            }



            if (!$alldata) {
                // Check if any of the fields were empty and show the first missing field's alert
                echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
                // Check if the username already exists
                $username = $_POST['username'];
                $check_username_query = "SELECT * FROM user WHERE username = '$username'";
                $result = mysqli_query($conn, $check_username_query);

                if (mysqli_num_rows($result) > 0) {
                    // Username already exists
                    $message = "Username already exists. Please choose a different one.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                } else {
                    // All fields are filled, and username is unique; proceed with database insertion
                    $firstName = $_POST['firstname'];
                    $lastName = $_POST['lastname'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $dob = $_POST['dob'];

                    $stmt = $conn->prepare("INSERT INTO user (fname, lname, username, email, password, dob) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $firstName, $lastName, $username, $email, $password, $dob);
                    $execval = $stmt->execute();

                    if ($execval) {
                        $message = "Registered successfully!";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                    } else {
                        $message = "Registration failed!";
                        echo "<script type='text/javascript'>alert('$message');</script>";
                    }
                    $stmt->close();
                }
            }
            $conn->close();
        }
    ?>


    <div class="register-container">
        <h1>Dhwani</h1>

        <a href="http://localhost/Project/02_login.php">Already have an account? Login here.</a>
        <form action="" method="post">
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstname" placeholder="Enter your first name">

            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastname" placeholder="Enter your last name">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">

                <!-- Other registration fields -->
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>
        

            <button type="submit">Register</button>
        </form>
    </div>

</body>
</html>