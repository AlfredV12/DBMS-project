<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
            align-items: flex-start;
            padding: 20px;
        }

        .dhwani-link {
            margin-bottom: 20px;
        }

        .dhwani-link a {
            text-decoration: none;
            color: white;
            font-size: 50px; /* Adjusted font size */
            font-family: 'Pacifico', cursive;
        }

        .profile-container {
            text-align: left;
            margin-bottom: 0px;
        }

        .profile-container h1 {
            color: #ecf0f1; /* Adjusted text color */
        }

        .profile-info {
            margin-bottom: 0px;
            font-size: 20px;
        }

        .edit-options {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 70px;
        }

        .edit-options a,
        .logout-button a {
            text-decoration: none;
        }

        .edit-options button,
        .logout-button button {
            padding: 10px;
            background-color: #2980b9;
            color: #ecf0f1;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px; /* Adjusted spacing */
            margin-bottom: 10px; /* Adjusted spacing */
            transition: background-color 0.3s;
        }

        .edit-options button:hover,
        .logout-button button:hover {
            background-color: #1a5276;
        }
    </style>
</head>
<body>

    <div class="dhwani-link">
        <a href="http://localhost/Project/01_home.php">Dhwani</a>
    </div>

    <div class="profile-container">     
        <?php

            session_start();

            // Check if the user is logged in
            if (isset($_SESSION['username'])) {
                echo '<div class="profile-info">';
                echo '<p><strong>First Name: </strong> ' . $_SESSION['fname'] . '</p>';
                echo '<p><strong>Last Name: </strong> ' . $_SESSION['lname'] . '</p>';
                echo '<p><strong>Username:  </strong> ' . $_SESSION['username'] . '</p>';
                echo '</div>';

                // Links to edit email and password pages
                echo '<div class="edit-options">';
                echo '<a href="edit-email.php"><button>Edit Email</button></a>';
                echo '<a href="edit-password.php"><button>Edit Password</button></a>';
                echo '</div>';
            } else {
                // If not logged in, redirect to the login page
                header("Location: 02_login.php");
                exit();
            }
        ?>
    </div>

    <div class="logout-button">
        <a href="http://localhost/Project/13_logout.php"><button>Logout</button></a>
    </div>

</body>
</html>