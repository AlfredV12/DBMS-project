<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["songId"])) {
    $conn = new mysqli('localhost', 'root', '', 'dhwani');

    if (!$conn) {
        die("Connection Failed: " . mysqli_connect_error());
    }

    $username = $_SESSION['username'];
    $songId = $_POST["songId"];

    // Function to handle adding a song to the liked table
    function addToLiked($username, $song_id, $conn) {
        $checkStmt = $conn->prepare("SELECT * FROM liked WHERE username = ? AND song_id = ?");
        $checkStmt->bind_param("ss", $username, $song_id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Song is already liked
            return "already_liked";
        } else {
            // Song is not liked, insert into the liked table
            $insertStmt = $conn->prepare("INSERT INTO liked (username, song_id, liked_date) VALUES (?, ?, CURDATE())");
            $insertStmt->bind_param("ss", $username, $song_id);
            $insertStmt->execute();
            $insertStmt->close();
            return "added";
        }

        $checkStmt->close();
    }

    // Call the addToLiked function to add the liked song
    $result = addToLiked($username, $songId, $conn);

    echo $result;

    $conn->close();
}
?>