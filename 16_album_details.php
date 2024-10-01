<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Details</title>

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
            padding: 20px;
        }

        h2,
        p {
            color: #ecf0f1; /* Adjusted text color */
        }

        .links-container {
            display: flex;
            justify-content: space-between;
            align-items: center; /* Align items vertically in the center */
            width: 80%;
            margin-bottom: 20px;
        }

        /* Add your own styles for links */
        a {
            color: white; /* Set the color to your preferred value */
            text-decoration: none; /* Add underline if desired */
        }

        /* Additional styling for links on hover */
        a:hover {
            color: #2980b9; /* Change color on hover */
        }

        .left-link {
            font-size: 50px;
            font-family: 'Pacifico', cursive; /* Apply Pacifico font style to Dhwani */
        }

        /* Style for the search form */
        form {
            display: flex;
            margin-top: 10px; /* Adjust the top margin to create space between the album title and the search form */
        }

        input[type="text"] {
            padding: 8px;
            margin-right: 8px; /* Add margin to the right of the input field */
            border-radius: 25px;
            border-style: solid;
        }

        button {
            /* Button background color */
            color: white;
            background-color: #2c3e50;
            padding: 8px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            color: #2980b9;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ecf0f1; /* Adjusted border color */
            padding: 8px;
            text-align: center;
        }

        .right-links {
            font-size: 20px;
        }

        .audio-controls {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="links-container">
        <div class="left-link">
            <a href="http://localhost/Project/01_home.php">Dhwani</a>
        </div>

        <form method="get" action="http://localhost/Project/14_album.php">
            <input type="text" name="search_title" placeholder="Search by Album Title..." required>
            <button type="submit">Search</button>
        </form>


        <div class="right-links">
            <div class="right-link">
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<a href="http://localhost/Project/05_profile.php">Profile</a>';
                } else {
                    echo '<a href="http://localhost/Project/02_login.php">Login</a>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    $conn = new mysqli('localhost', 'root', '', 'dhwani');

    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    // Check if the album title is provided in the form submission
    if (isset($_GET['title'])) {
        $search_title = $_GET['title'];

        // Fetch album information based on album title
        $stmt = $conn->prepare("SELECT * FROM album WHERE title LIKE ?");
        $search_param = "%$search_title%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<div id="search_results"></div>';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<h2>{$row['title']}</h2>";
                echo "<p>Release Date: {$row['release_date']}</p>";

                // Fetch all songs in the album
                $stmt_songs = $conn->prepare("SELECT * FROM song WHERE album_id = ?");
                $stmt_songs->bind_param("s", $row['album_id']);
                $stmt_songs->execute();
                $songs_result = $stmt_songs->get_result();

                // Display the songs in tabular form
                echo "<h2>Songs:</h2>";

                if ($songs_result->num_rows > 0) {
                    echo "<table>
                            <tr>
                                <th>Title</th>
                                <th>Genre</th>
                                <th>Release Date</th>
                                <th>Play Audio</th>
                            </tr>";
                    while ($song_row = $songs_result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$song_row['title']}</td>
                                <td>{$song_row['genre']}</td>
                                <td>{$song_row['release_date']}</td>
                                <td class='audio-controls'>
                                    <audio controls>
                                        <source src=\"http://localhost/Project{$song_row['audio_url']}\" type=\"audio/mp3\">
                                        Your browser does not support the audio element.
                                    </audio>
                                </td>
                            </tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p>No songs found for this album.</p>";
                }
            }
        } else {
            echo "<p>No albums found for the provided title.</p>";
        }

        $stmt->close();
        $stmt_songs->close();
    } else {
        echo "<p>Album title not provided for search.</p>";
    }

    $conn->close();
    ?>

</body>

</html>
