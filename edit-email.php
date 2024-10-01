<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Email</title>
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

        .edit-container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .edit-container h1 {
            color: #2c3e50; /* Dark background color */
        }   


        .edit-container label {
            display: block;
            margin-bottom: 8px;
        }

        .edit-container input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .edit-container button {
            width: 100%;
            padding: 10px;
            background-color: #2980b9; /* Adjusted color */
            color: #ecf0f1; /* Adjusted text color */
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-container button:hover {
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

          // Validate and sanitize the new email
          $newEmail = filter_var($_POST["new_email"], FILTER_SANITIZE_EMAIL);

          // Update the user's email in the database
          $username = $_SESSION['username'];
          $updateQuery = "UPDATE user SET email = ? WHERE username = ?";
          $stmt = $conn->prepare($updateQuery);
          $stmt->bind_param("ss", $newEmail, $username);
          
          if ($stmt->execute()) {
              // Email updated successfully
              $_SESSION['email'] = $newEmail;
              echo "<script>alert('Email updated successfully.');</script>";
          } else {
              // Error updating email
              echo "<script>alert('Error updating email.');</script>";
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

    <div class="edit-container">
        <h1>Edit Email</h1>
        <form method="post">
            <label for="new_email"></label>
            <input type="email" id="new_email" name="new_email" placeholder="Enter your new email" required>

            <button type="submit">Submit</button>
        </form>
    </div>

</body>
</html>
