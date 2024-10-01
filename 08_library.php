<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Playlists</title>
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

        <form action="http://localhost/Project/12_search.php" method="post">
            <input type="text" name="search" id="search" placeholder="Search for a song" required>
            <button class="btn" type="submit">Search</button>
        </form>

        <a href="http://localhost/Project/15_create_playlist.php" class="create-playlist-button">Create Playlist+</a>

        <div class="right-links">
            <div class="right-link">
                <?php
                // Check if the user is logged in
                if (isset($_SESSION['username'])) {
                    // If logged in, show a link to the profile
                    echo '<a href="http://localhost/Project/05_profile.php">Profile</a>';
                    // Show the "Your Library" button only if logged in
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

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
        // Sanitize the search query to prevent SQL injection
        $search_query = mysqli_real_escape_string($conn, $_POST["search"]);

        // Display playlists created by the logged-in user that match the search query
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];

            $stmt = $conn->prepare("SELECT * FROM playlist WHERE username = ? AND title LIKE ?");
            $search_param = "%" . $search_query . "%";
            $stmt->bind_param("ss", $username, $search_param);
            $stmt->execute();

            $result = $stmt->get_result();

            // Display the search results in tabular form
            echo "<h2>Search Results:</h2>";

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Title</th>
                            <th>Date Created</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    // Output the playlist information in tabular form
                    echo "<tr>
                            <td><a href=\"http://localhost/Project/10_playlist_songs.php?id={$row['playlist_id']}\">{$row['title']}</a></td>
                            <td>{$row['create_date']}</td>
                          </tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No results found.</p>";
            }

            $stmt->close();
        }
    } else {
        // Display playlists created by the logged-in user
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            $result = $conn->query("SELECT * FROM playlist WHERE username = '$username'");

            echo "<h2>Your Playlists:</h2>";

            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>Title</th>
                            <th>Date Created</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    // Output the playlist information in tabular form
                    echo "<tr>
                            <td><a href=\"http://localhost/Project/10_playlist_songs.php?id={$row['playlist_id']}\">{$row['title']}</a></td>
                            <td>{$row['create_date']}</td>
                          </tr>";
                }

                echo "</table>";
            } else {
                echo "<p>No playlists found.</p>";
            }
        }
    }

    $conn->close();
    ?>

</body>

</html>