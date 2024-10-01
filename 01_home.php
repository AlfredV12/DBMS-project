<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dhwani</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: url('./images/Main.jpg') center/cover; /* Set background image */
            color: white;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }

        .logo {
            font-size: 60px;
            font-family: 'Pacifico', cursive;
            text-decoration: none;
            color: #ecf0f1; /* Light text color */
        }

        .navigation {
            display: flex;
            align-items: center;
        }

        .navigation a {
            text-decoration: none;
            color: #ecf0f1;
            margin: 0 20px;
            font-size: 18px;
            transition: color 0.3s;
        }

        .navigation a:hover {
            color: #3498db; /* Highlight color on hover */
        }

        .search {
            display: flex;
            align-items: center;
        }

        .search input {
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            background-color: rgba(52, 73, 94, 0.6); /* Input background color with transparency */
            color: #ecf0f1; /* Light text color */
            font-size: 14px;
        }

        .search button {
            padding: 10px;
            background-color: rgba(41, 128, 185, 0.3); /* Button color with transparency */
            border: none;
            color: #ecf0f1; /* Light text color */
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        /* Pill button styles */
        .pill-button {
            width: 200px;
            height: 120px;
            background-color: rgba(52, 152, 219, 0.3); /* Pill button color with transparency */
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            text-decoration: none;
            margin: 0 10px;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .search button:hover {
            background-color: #1a5276; /* Darker button color on hover */
        }

        .pill-buttons {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .pill-button {
            width: 200px;
            height: 120px;
            background-color: rgba(52, 152, 219, 0.8); /* Pill button color with transparency */
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            text-decoration: none;
            margin: 0 10px;
            transition: background-color 0.3s;
            font-size: 16px;
        }

        .pill-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <a href="http://localhost/Project/01_home.php" class="logo">Dhwani</a>

        <div class="navigation">
            <a href="http://localhost/Project/01_home.php">Home</a>
            <?php
            // Check if the user is logged in
            if (isset($_SESSION['username'])) {
                // If logged in, show a link to the profile
                echo '<a href="http://localhost/Project/05_profile.php">Profile</a>';
                // Show the "Your Library" button only if logged in
                echo '<a href="http://localhost/Project/08_library.php">Your Library</a>';
            } else {
                // If not logged in, show a link to the login page
                echo '<a href="http://localhost/Project/02_login.php">Login</a>';
            }
            ?>
            <a href="http://localhost/Project/06_artist.php">Artists</a>
            <a href="http://localhost/Project/14_album.php">Albums</a>
        </div>

        <div class="search">        
            <form action="http://localhost/Project/12_search.php" method="post">
                <input type="text" name="search" id="search" placeholder="Search for a song" required>
                <button class="btn" type="submit">Search</button>
            </form>
        </div>
    </div>

    <!-- Pill Buttons (Latest Songs and Liked Songs) -->
    <div class="pill-buttons">
        <a href="http://localhost/Project/latest_songs.php" class="pill-button">
            Latest Songs
        </a>

        <?php
        if(isset($_SESSION['username'])){
            echo '<a href="http://localhost/Project/like_songs.php" class="pill-button">Liked Songs</a>';
            }
        ?>
    </div>

</body>
</html>