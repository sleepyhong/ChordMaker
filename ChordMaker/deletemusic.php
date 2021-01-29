<?php
    session_start();

    // Create MySql database connection
    $connection = new mysqli("127.0.0.1", "root", "Sm10230420?", "chordmaker");

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // check whether the hidden inputs have inputs
    if (isset($_POST['title']) && isset($_POST['writers']) && isset($_POST['album']) && isset($_POST['date'])) {
        $title = $_POST['title'];
        $writers = $_POST['writers'];
        $album = $_POST['album'];
        $date = $_POST['date'];
        print_r($_POST);

        // delete a selected row from a database
        $sql = "DELETE FROM " . $_SESSION['username'] . " WHERE Title=\"$title\" AND Songwriters=\"$writers\" AND Album=\"$album\" AND LastModified=\"$date\"";
        if ($connection->query($sql) == TRUE) {
            header("Location: chorddrive.php");
        }
        else {
            echo "Error: " . $sql . "<br>" . $connection->error;
        }
    }
    else {
        print_r($_POST);
    }
    
    $connection->close();
?>