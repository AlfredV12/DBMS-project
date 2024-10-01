<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liked Songs</title>
    <link rel="stylesheet" href="project.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

</head>

<body>

    <div class="links-container">
        <div class="left-link">
            <a href="http://localhost/Project/01_home.php">Dhwani</a>
        </div>

        <form method="post" action="http://localhost/Project/12_search.php">
            <input type="text" name="search" placeholder="Search for a song" required>
            <button type="submit">Search</button>
        </form>

        <div class="right-links">
            <div class="right-link">
                <?php
                // Check if the user is logged in
                if (isset($_SESSION['username'])) {
                    // If logged in, show a link to the profile
                    echo '<a href="http://localhost/Project/05_profile.php">Profile</a>';
                } else {
                    // If not logged in, show a link to the login page
                    echo '<a href="http://localhost/Project/02_login.php">Login</a>';
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    // Assuming you have a database connection established earlier
    $conn = new mysqli('localhost', 'root', '', 'dhwani');

    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        // Fetch liked songs for the logged-in user
        $username = $_SESSION['username'];
        $stmt = $conn->prepare("SELECT liked.song_id, liked.liked_date, song.title, song.genre, song.release_date, song.audio_url 
                                FROM liked 
                                JOIN song ON liked.song_id = song.song_id
                                WHERE liked.username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display the liked songs in tabular form
        echo "<h2>Liked Songs:</h2>";

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Liked Date</th>
                        <th>Play Audio</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                // Output the liked song information in tabular form
                echo "<tr>
                        <td>{$row['title']}</td>
                        <td>{$row['genre']}</td>
                        <td>{$row['liked_date']}</td>
                        <td>
                            <audio controls>
                                <source src=\"http://localhost/Project{$row['audio_url']}\" type=\"audio/mp3\">
                                Your browser does not support the audio element.
                            </audio>
                        </td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No liked songs found.</p>";
        }

        $stmt->close();
    } else {
        // If the user is not logged in, show a message
        echo "<p>Please log in to view liked songs.</p>";
    }

    $conn->close();
    ?>

</body>

</html>
