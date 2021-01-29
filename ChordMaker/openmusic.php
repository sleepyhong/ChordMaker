<?php
    session_start();
    if (isset($_POST['title']) && isset($_POST['writers']) && isset($_POST['album']) && isset($_POST['date'])) {
        $_SESSION["title"] = $_POST['title'];
        $_SESSION["writers"] = $_POST['writers'];
        $_SESSION["album"] = $_POST['album'];
        $_SESSION["date"] = $_POST['date'];

        header("Location: workspace.php");
    }
    else {
        print_r($_POST);
    }
?>