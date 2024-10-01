<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Playlist</title>
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
            align-items: center;
            justify-content: center;
        }

        .dhwani-link {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .dhwani-link a {
            text-decoration: none;
            color: white;
            font-size: 50px; /* Adjusted font size */
            font-family: 'Pacifico', cursive;
        }

        .create-container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .create-container h1 {
            color: #2c3e50; /* Dark background color */
        }

        .create-container label {
            display: block;
            margin-bottom: 8px;
        }

        .create-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .create-container button {
            width: 100%;
            padding: 10px;
            background-color: #2980b9; /* Adjusted color */
            color: #ecf0f1; /* Adjusted text color */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .create-container button:hover {
            background-color: #1a5276; /* Darker button color on hover */
        }
    </style>
</head>

<body>

    <?php
    // Start the session
    session_start();

    // Check if the user is not logged in, redirect to login page
    if (!isset($_SESSION['username'])) {
        header("Location: 02_login.php");
        exit();
    }

    $conn = new mysqli('localhost', 'root', '', 'dhwani');

    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Validate and sanitize the playlist title
        $playlistTitle = filter_var($_POST["playlist_title"], FILTER_SANITIZE_STRING);

        do {
            // Generate a new playlist_id
            $playlistId = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_=+[]{}|;:,.<>?'), 0, 10);
    
            // Check if the generated playlist_id already exists in the database
            $checkQuery = "SELECT COUNT(*) FROM playlist WHERE playlist_id = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param("s", $playlistId);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();
        } while ($count > 0);

        // Capture real-time date
        $currentDate = date("Y-m-d");

        // Get the username from the session
        $username = $_SESSION['username'];

        // Insert the playlist into the database
        $insertQuery = "INSERT INTO playlist (playlist_id, title, create_date, username) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $playlistId, $playlistTitle, $currentDate, $username);

        if ($stmt->execute()) {
            // Playlist created successfully
            echo "<script>alert('Playlist created successfully.');</script>";
        } else {
            // Error creating playlist
            echo "<script>alert('Error creating playlist.');</script>";
        }

        // Close the statement
        $stmt->close();
    }

    // Close the database connection
    $conn->close();
    ?>

    <div class="dhwani-link">
        <a href="http://localhost/Project/01_home.php">Dhwani</a>
    </div>

    <div class="create-container">
        <h1>Create Playlist</h1>
        <form method="post">
            <label for="playlist_title">Playlist Title:</label>
            <input type="text" id="playlist_title" name="playlist_title" placeholder="Enter playlist title" required>

            <button type="submit">Create Playlist</button>
        </form>
    </div>

</body>

</html>
