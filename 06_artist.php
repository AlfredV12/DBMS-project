<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artists</title>
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
            <input type="text" name="search" placeholder="Search for an artist" required>
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

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
        // Sanitize the search query to prevent SQL injection
        $search_query = mysqli_real_escape_string($conn, $_POST["search"]);

        // Use the search query to fetch artists from the database
        $stmt = $conn->prepare("SELECT * FROM artist WHERE name LIKE ?");
        $search_param = "%" . $search_query . "%";
        $stmt->bind_param("s", $search_param);
        $stmt->execute();

        $result = $stmt->get_result();

        // Display the search results in tabular form
        echo "<h2>Search Results:</h2>";

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                // Output the artist information in tabular form
                echo "<tr>
                        <td><a href=\"11_artist_bio.php?id={$row['artist_id']}\">{$row['artist_id']}</a></td>
                        <td>{$row['name']}</td>
                        <td>{$row['dob']}</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No results found.</p>";
        }

        $stmt->close();
    } else {
        // Display 20 random artists initially
        $result = $conn->query("SELECT * FROM artist ORDER BY RAND() LIMIT 20");

        echo "<h2>Random Artists:</h2>";

        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Date of Birth</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                // Output the artist information in tabular form
                echo "<tr>
                        <td><a href=\"11_artist_bio.php?id={$row['artist_id']}\">{$row['artist_id']}</a></td>
                        <td>{$row['name']}</td>
                        <td>{$row['dob']}</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No artists found.</p>";
        }
    }

    $conn->close();
    ?>

</body>

</html>