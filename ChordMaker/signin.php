<?php
    session_start();

    // Create MySql database connection
    $connection = new mysqli("127.0.0.1", "root", "Sm10230420?", "chordmaker");

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Initialize username and password
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Create a Cookie for a month
        $_SESSION["username"] = $username;

        // Check if the password matches to the existing username
        $result = $connection->query("SELECT Username, Password FROM users WHERE Username = \"$username\"") or die($connection->error);
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            // Redirect to ChordDrive.html after successful login
            if ($row["Password"] == $password) {
                header("Location: chorddrive.php");
            }
            // Notifies the user that login has failed when the password is incorrect
            else {
                echo "Login Failed: Incorrect username or password.";
            }
        }
        // Notifies the user that login has failed when the username is incorrect
        else {
            echo "Login Failed: Incorrect username or password.";
        }
    }

    $connection->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>ChordMaker Sign In Page</title>
    </head>
    <body>
        <h1>Sign In</h1>
        <div>
            <form action="" method="POST">
                <div>
                    <label for="username">Username </label>
                    <input type="text" name="username" placeholder="Enter Your User Name">
                </div>
                <div>
                    <label for="password">Password </label>
                    <input type="password" name="password" placeholder="Enter Your Password">
                </div>
                <div>
                    <input type="submit" value="Sign In">
                </div>
            </form>
        </div>
    </body>
</html>

