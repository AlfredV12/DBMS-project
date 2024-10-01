<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
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

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="search" placeholder="Search..." required>
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

    // Function to handle adding a song to the liked table
    function addToLiked($username, $song_id, $conn) {
        $stmt = $conn->prepare("INSERT INTO liked (username, song_id, liked_date) VALUES (?, ?, CURDATE())");
        $stmt->bind_param("ss", $username, $song_id);
        $stmt->execute();
        $stmt->close();
    }

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
        // Sanitize the search query to prevent SQL injection
        $search_query = mysqli_real_escape_string($conn, $_POST["search"]);

        // Use the search query to fetch songs from the database
        $stmt = $conn->prepare("SELECT * FROM song WHERE title LIKE ?");
        $search_param = "%" . $search_query . "%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();

        $result = $stmt->get_result();

        // Display the search results in tabular form
        echo "<h2>Search Results:</h2>";

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Release Date</th>
                        <th>Play Audio</th>
                        <th>Add to Liked</th>
                    </tr>";

            while ($row = $result->fetch_assoc()) {
                // Output the song information in tabular form
                echo "<tr>
                        <td>{$row['title']}</td>
                        <td>{$row['genre']}</td>
                        <td>{$row['release_date']}</td>
                        <td>
                            <audio controls>
                                <source src=\"http://localhost/Project" . $row['audio_url'] . "\" type=\"audio/mp3\">
                                Your browser does not support the audio element.
                            </audio>
                        </td>
                        <td>";

                // Display the button if the user is logged in
                if (isset($_SESSION['username'])) {
                    echo "<button class='like-btn' data-song-id='{$row['song_id']}'>Add to Liked</button>";
                }

                echo "</td></tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No results found.</p>";
        }

        $stmt->close();
    }

    $conn->close();
    ?>

    <!-- Add jQuery library -->
    <!-- Add jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function () {
            // Handle like button click
            $(".like-btn").click(function () {
                var songId = $(this).data("song-id");

                $.ajax({
                    type: "POST",
                    url: "add_to_liked.php",
                    data: {
                        songId: songId
                    },
                    success: function (response) {
                        if (response === "added") {
                            alert("Song added to Liked!");
                        } else if (response === "already_liked") {
                            alert("You have already liked this song.");
                        } else {
                            alert("Error adding song to Liked!");
                        }
                    },
                    error: function () {
                        alert("Error adding song to Liked!");
                    }
                });
            });
        });
    </script>

</body>

</html>

</html>